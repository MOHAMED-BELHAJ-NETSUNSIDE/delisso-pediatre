import { useEffect, useMemo, useState } from 'react'
import type { FormEvent } from 'react'
import { useNavigate } from 'react-router-dom'
import { Geolocation } from '@capacitor/geolocation'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { Textarea } from '@/components/ui/textarea'
import GpsMap from '../components/GpsMap'
import MedecinSearch from '../components/MedecinSearch'
import PageHeader from '../components/PageHeader'
import { api } from '../lib/api'
import { parseGps } from '../lib/gps'
import type { Cadeau, Medecin } from '../lib/api'
import { compressImage } from '../lib/compress'

type QtyMap = Record<number, number>

export default function VisitePage() {
  const nav = useNavigate()
  const [cadeaux, setCadeaux] = useState<Cadeau[]>([])
  const [medecin, setMedecin] = useState<Medecin | null>(null)
  const [nvisite, setNvisite] = useState('1')
  const [classe, setClasse] = useState<string | null>(null)
  const [remarque, setRemarque] = useState('')
  const [gps, setGps] = useState('')
  const [qtys, setQtys] = useState<QtyMap>({})
  const [photos, setPhotos] = useState<File[]>([])
  const [error, setError] = useState('')
  const [loading, setLoading] = useState(false)

  useEffect(() => {
    let active = true
    api.cadeaux().then((r) => setCadeaux(r.data)).catch(() => undefined)

    async function readGps() {
      try {
        const status = await Geolocation.requestPermissions({ permissions: ['location'] })
        if (status.location !== 'granted' && status.coarseLocation !== 'granted') return
        const pos = await Geolocation.getCurrentPosition({ enableHighAccuracy: true, timeout: 15000 })
        if (active) setGps(`${pos.coords.latitude},${pos.coords.longitude}`)
      } catch {
        try {
          const pos = await Geolocation.getCurrentPosition({ enableHighAccuracy: true, timeout: 15000 })
          if (active) setGps(`${pos.coords.latitude},${pos.coords.longitude}`)
        } catch {
          // permission refusée ou GPS indisponible
        }
      }
    }

    readGps()
    return () => {
      active = false
    }
  }, [])

  const position = parseGps(gps)

  const selectedGifts = useMemo(
    () => Object.entries(qtys).filter(([, qty]) => qty > 0).map(([id, qty]) => ({ cadeau_id: Number(id), qty })),
    [qtys],
  )

  async function onPhotos(files: FileList | null) {
    if (!files) return
    const list = Array.from(files).slice(0, 5)
    const compressed: File[] = []
    for (const f of list) compressed.push(await compressImage(f))
    setPhotos(compressed)
  }

  async function onSubmit(e: FormEvent) {
    e.preventDefault()
    setError('')
    if (!medecin) {
      setError('Sélectionnez un médecin')
      return
    }
    if (selectedGifts.length === 0) {
      setError('Ajoutez au moins un cadeau')
      return
    }
    for (const g of selectedGifts) {
      const c = cadeaux.find((x) => x.id === g.cadeau_id)
      if (c && g.qty > c.stock) {
        setError(`Stock insuffisant: ${c.name}`)
        return
      }
    }

    setLoading(true)
    try {
      const form = new FormData()
      form.append('medecin_id', String(medecin.id))
      form.append('nvisite', nvisite)
      form.append('classe', classe ?? '')
      form.append('region', medecin.region || '')
      form.append('municipalite', medecin.municipalite || '')
      form.append('etab', medecin.etab != null ? String(medecin.etab) : '')
      form.append('name_etab', medecin.name_etab || '')
      form.append('gps', gps)
      form.append('remarque', remarque)
      form.append('cadeaux', JSON.stringify(selectedGifts))
      photos.forEach((p) => form.append('photos[]', p))
      await api.createVisite(form)
      nav('/', { replace: true })
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Erreur')
    } finally {
      setLoading(false)
    }
  }

  return (
    <div className="mx-auto min-h-full w-full max-w-lg">
      <PageHeader title="Nouvelle visite" />

      <form onSubmit={onSubmit} className="space-y-4 p-4">
        {error && (
          <Alert variant="destructive">
            <AlertDescription>{error}</AlertDescription>
          </Alert>
        )}

        <Card>
          <CardHeader>
            <CardTitle>Médecin</CardTitle>
          </CardHeader>
          <CardContent>
            <MedecinSearch selected={medecin} onSelect={setMedecin} />
          </CardContent>
        </Card>

        <Card>
          <CardContent className="grid grid-cols-2 gap-3">
            <div className="space-y-1.5">
              <Label>N° visite</Label>
              <Select value={nvisite} onValueChange={(value) => setNvisite(value ?? '1')}>
                <SelectTrigger className="w-full">
                  <SelectValue />
                </SelectTrigger>
                <SelectContent>
                  {['1', '2', '3', '4'].map((n) => <SelectItem key={n} value={n}>{n}</SelectItem>)}
                </SelectContent>
              </Select>
            </div>
            <div className="space-y-1.5">
              <Label>Classe</Label>
              <Select value={classe} onValueChange={(value) => setClasse(value)}>
                <SelectTrigger className="w-full">
                  <SelectValue placeholder="—" />
                </SelectTrigger>
                <SelectContent>
                  {['A', 'A+', 'B', 'C'].map((c) => <SelectItem key={c} value={c}>{c}</SelectItem>)}
                </SelectContent>
              </Select>
            </div>
            <div className="col-span-2 space-y-1.5">
              <Label htmlFor="remarque">Remarque</Label>
              <Textarea id="remarque" value={remarque} onChange={(e) => setRemarque(e.target.value)} />
            </div>
            <div className="col-span-2 space-y-2">
              <div className="text-xs text-muted-foreground">GPS: {gps || 'non disponible'}</div>
              {position && <GpsMap lat={position.lat} lng={position.lng} />}
            </div>
          </CardContent>
        </Card>

        <Card>
          <CardHeader>
            <CardTitle>Cadeaux</CardTitle>
          </CardHeader>
          <CardContent className="space-y-3">
            {cadeaux.map((c) => (
              <div key={c.id} className="flex items-center justify-between gap-3 border-b border-border pb-2">
                <div>
                  <div className="text-sm font-medium">{c.name}</div>
                  <div className="text-xs text-muted-foreground">Stock: {c.stock}</div>
                </div>
                <Input
                  type="number"
                  min={0}
                  max={c.stock}
                  className="w-20"
                  value={qtys[c.id] ?? 0}
                  onChange={(e) => setQtys((prev) => ({ ...prev, [c.id]: Number(e.target.value) }))}
                />
              </div>
            ))}
          </CardContent>
        </Card>

        <Card>
          <CardHeader>
            <CardTitle>Photos (max 5, compressées)</CardTitle>
          </CardHeader>
          <CardContent className="space-y-2">
            <Input type="file" accept="image/*" multiple capture="environment" onChange={(e) => onPhotos(e.target.files)} />
            <div className="flex flex-wrap gap-2">
              {photos.map((p, i) => (
                <span key={i} className="rounded bg-muted px-2 py-1 text-xs">{p.name} ({Math.round(p.size / 1024)} Ko)</span>
              ))}
            </div>
          </CardContent>
        </Card>

        <Button disabled={loading} className="h-11 w-full rounded-xl text-base" type="submit">
          {loading ? 'Envoi…' : 'Valider la visite'}
        </Button>
      </form>
    </div>
  )
}
