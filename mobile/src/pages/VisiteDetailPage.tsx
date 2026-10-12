import { useEffect, useState } from 'react'
import { useLocation, useParams } from 'react-router-dom'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Dialog, DialogClose, DialogContent, DialogTitle } from '@/components/ui/dialog'
import { XIcon } from 'lucide-react'
import GpsMap from '../components/GpsMap'
import PageHeader from '../components/PageHeader'
import { api, formatDate, mediaUrl } from '../lib/api'
import type { VisiteDetail } from '../lib/api'
import { parseGps } from '../lib/gps'

export default function VisiteDetailPage() {
  const { id } = useParams()
  const location = useLocation()
  const backTo = (location.state as { from?: string } | null)?.from || '/historique'
  const [visite, setVisite] = useState<VisiteDetail | null>(null)
  const [error, setError] = useState('')
  const [photoSrc, setPhotoSrc] = useState<string | null>(null)

  useEffect(() => {
    if (!id) return
    api.visite(Number(id))
      .then((r) => setVisite(r.data))
      .catch((e) => setError(e instanceof Error ? e.message : 'Visite introuvable'))
  }, [id])

  const rows = visite
    ? [
        ['N° visite', String(visite.nvisite)],
        ['Classe', visite.classe],
        ['Région', visite.region],
        ['Municipalité', visite.municipalite],
        ['Type d’établissement', visite.etab],
        ['Établissement', visite.name_etab],
        ['Remarque', visite.remarque],
      ].filter((row): row is [string, string] => Boolean(row[1]))
    : []
  const position = visite ? parseGps(visite.gps) : null

  return (
    <div className="mx-auto min-h-full w-full max-w-lg">
      <PageHeader title="Détail de la visite" fallback={backTo} />
      <div className="space-y-4 p-4">

      {error && (
        <Alert variant="destructive">
          <AlertDescription>{error}</AlertDescription>
        </Alert>
      )}

      {!visite && !error && (
        <div className="space-y-3">
          <div className="h-40 animate-pulse rounded-2xl bg-white ring-1 ring-[#0b2a5b]/8" />
          <div className="h-24 animate-pulse rounded-2xl bg-white ring-1 ring-[#0b2a5b]/8" />
        </div>
      )}

      {visite && (
        <>
          <Card>
            <CardHeader>
              <CardTitle>{visite.medecin_name}</CardTitle>
              <CardDescription>{formatDate(visite.created_at)}</CardDescription>
            </CardHeader>
            <CardContent className="space-y-3">
              {rows.map(([label, value]) => (
                <div key={label}>
                  <div className="text-muted-foreground">{label}</div>
                  <div>{value}</div>
                </div>
              ))}
              {visite.gps && (
                <div className="space-y-2">
                  <div className="text-muted-foreground">Position</div>
                  {position ? <GpsMap lat={position.lat} lng={position.lng} /> : <div>{visite.gps}</div>}
                </div>
              )}
            </CardContent>
          </Card>

          <Card>
            <CardHeader>
              <CardTitle>Cadeaux remis</CardTitle>
            </CardHeader>
            <CardContent className="space-y-2">
              {visite.cadeaux.length === 0 && <p className="text-muted-foreground">Aucun cadeau.</p>}
              {visite.cadeaux.map((cadeau, index) => (
                <div key={`${cadeau.name}-${index}`} className="flex items-center justify-between gap-3">
                  <span>{cadeau.name}</span>
                  <Badge variant="secondary">{cadeau.qty}</Badge>
                </div>
              ))}
            </CardContent>
          </Card>

          {visite.photos.length > 0 && (
            <Card>
              <CardHeader>
                <CardTitle>Photos</CardTitle>
              </CardHeader>
              <CardContent className="grid grid-cols-2 gap-2">
                {visite.photos.map((photo, index) => {
                  const src = photo.content || mediaUrl(photo.url)
                  if (!src) return null
                  return (
                    <button
                      key={`${photo.url}-${index}`}
                      type="button"
                      onClick={() => setPhotoSrc(src)}
                      className="overflow-hidden rounded-lg focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#0b2a5b]"
                      aria-label="Agrandir la photo"
                    >
                      <img
                        src={src}
                        alt=""
                        className="aspect-square w-full object-cover"
                      />
                    </button>
                  )
                })}
              </CardContent>
            </Card>
          )}
        </>
      )}
      </div>

      <Dialog open={photoSrc !== null} onOpenChange={(open) => { if (!open) setPhotoSrc(null) }}>
        <DialogContent
          showCloseButton={false}
          overlayClassName="bg-black/85"
          className="inset-0 flex h-full w-full max-w-none translate-none items-center justify-center bg-transparent p-4 shadow-none ring-0 sm:max-w-none"
        >
          <DialogTitle className="sr-only">Photo de la visite</DialogTitle>
          <button
            type="button"
            className="absolute inset-0"
            aria-label="Fermer la photo"
            onClick={() => setPhotoSrc(null)}
          />
          <DialogClose
            render={
              <Button
                variant="secondary"
                size="icon-sm"
                className="absolute top-3 right-3 z-10"
              />
            }
          >
            <XIcon />
            <span className="sr-only">Fermer</span>
          </DialogClose>
          {photoSrc && (
            <img
              src={photoSrc}
              alt="Photo de la visite"
              className="relative z-10 max-h-[85vh] max-w-full rounded-xl object-contain"
            />
          )}
        </DialogContent>
      </Dialog>
    </div>
  )
}
