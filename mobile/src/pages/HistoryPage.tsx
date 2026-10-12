import { useEffect, useMemo, useState } from 'react'
import { Link } from 'react-router-dom'
import { ChevronRight, Gift, MapPin, Search, Stethoscope, Users, X } from 'lucide-react'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { Card, CardHeader } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Skeleton } from '@/components/ui/skeleton'
import { cn } from '@/lib/utils'
import PageHeader from '../components/PageHeader'
import { api } from '../lib/api'
import type { Visite } from '../lib/api'

const statStyles = [
  { key: 'visites' as const, label: 'Visites', icon: Stethoscope },
  { key: 'medecins' as const, label: 'Médecins', icon: Users },
  { key: 'regions' as const, label: 'Régions', icon: MapPin },
]

function plural(count: number, singular: string, pluralForm: string) {
  return `${count} ${count === 1 ? singular : pluralForm}`
}

function initials(name: string) {
  const cleaned = name.replace(/^(dr|dre|pr|sf|mme|mlle|mr|m)\.?\s+/i, '').trim()
  const parts = cleaned.split(/\s+/).filter(Boolean)
  const first = parts[0]?.[0] ?? ''
  const last = parts.length > 1 ? parts[parts.length - 1]?.[0] ?? '' : ''
  return (first + last).toUpperCase() || '—'
}

function placeOf(visite: Visite) {
  if (visite.municipalite && visite.region && visite.municipalite !== visite.region) {
    return `${visite.municipalite} · ${visite.region}`
  }
  return visite.municipalite || visite.region || 'Lieu non renseigné'
}

function startOfDay(date: Date) {
  return new Date(date.getFullYear(), date.getMonth(), date.getDate()).getTime()
}

function dayLabel(time: number) {
  const date = new Date(time)
  const diff = Math.round((startOfDay(new Date()) - time) / 86_400_000)
  if (diff === 0) return 'Aujourd’hui'
  if (diff === 1) return 'Hier'
  const formatted = new Intl.DateTimeFormat('fr-FR', {
    weekday: 'long',
    day: 'numeric',
    month: 'long',
    year: date.getFullYear() === new Date().getFullYear() ? undefined : 'numeric',
  }).format(date)
  return formatted.charAt(0).toUpperCase() + formatted.slice(1)
}

function fullDate(time: number) {
  return new Intl.DateTimeFormat('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' }).format(new Date(time))
}

function timeLabel(value: string) {
  const date = new Date(value)
  if (Number.isNaN(date.getTime())) return ''
  return new Intl.DateTimeFormat('fr-FR', { hour: '2-digit', minute: '2-digit' }).format(date)
}

function toInputValue(time: number) {
  const date = new Date(time)
  const month = String(date.getMonth() + 1).padStart(2, '0')
  const day = String(date.getDate()).padStart(2, '0')
  return `${date.getFullYear()}-${month}-${day}`
}

function fromInputValue(value: string) {
  const match = /^(\d{4})-(\d{2})-(\d{2})$/.exec(value)
  if (!match) return null
  const date = new Date(Number(match[1]), Number(match[2]) - 1, Number(match[3]))
  return Number.isNaN(date.getTime()) ? null : startOfDay(date)
}

export default function HistoryPage() {
  const today = startOfDay(new Date())
  const [rows, setRows] = useState<Visite[] | null>(null)
  const [error, setError] = useState('')
  const [query, setQuery] = useState('')
  const [selected, setSelected] = useState(today)

  useEffect(() => {
    api.visitesMe()
      .then((r) => setRows(r.data))
      .catch((e) => {
        setRows([])
        setError(e instanceof Error ? e.message : 'Erreur')
      })
  }, [])

  const ofDay = useMemo(
    () => (rows ?? []).filter((visite) => startOfDay(new Date(visite.created_at)) === selected),
    [rows, selected],
  )

  const visible = useMemo(() => {
    const term = query.trim().toLocaleLowerCase('fr')
    if (!term) return ofDay
    return ofDay.filter((visite) => {
      const haystack = [visite.medecin_name, visite.region, visite.municipalite].filter(Boolean).join(' ').toLocaleLowerCase('fr')
      return haystack.includes(term)
    })
  }, [ofDay, query])

  const figures = useMemo(() => ({
    visites: ofDay.length,
    medecins: new Set(ofDay.map((visite) => visite.medecin_name)).size,
    regions: new Set(ofDay.map((visite) => visite.region).filter(Boolean)).size,
  }), [ofDay])

  const searching = query.trim().length > 0
  const subtitle = rows === null
    ? 'Chargement…'
    : `${dayLabel(selected)} · ${plural(ofDay.length, 'visite', 'visites')}`

  function onDate(value: string) {
    const time = fromInputValue(value)
    if (time === null || time > today) return
    setSelected(time)
  }

  function showToday() {
    setSelected(startOfDay(new Date()))
  }

  return (
    <div className="mx-auto min-h-full w-full max-w-lg">
      <PageHeader title="Historique" subtitle={subtitle}>
        <div className="px-4 pb-3">
          <div className="relative">
            <Search className="pointer-events-none absolute top-1/2 left-2.5 size-4 -translate-y-1/2 text-white/70" />
            <Input
              value={query}
              onChange={(e) => setQuery(e.target.value)}
              placeholder="Médecin ou ville"
              aria-label="Rechercher une visite"
              className="h-10 border-white/15 bg-white/10 pr-9 pl-8 text-white placeholder:text-white/60"
            />
            {query && (
              <Button
                type="button"
                variant="ghost"
                size="icon-xs"
                className="absolute top-1/2 right-1.5 -translate-y-1/2 text-white hover:bg-white/10 hover:text-white"
                aria-label="Effacer la recherche"
                onClick={() => setQuery('')}
              >
                <X />
              </Button>
            )}
          </div>
        </div>
      </PageHeader>

      <div className="space-y-5 p-4">
        {error && (
          <Alert variant="destructive">
            <AlertDescription>{error}</AlertDescription>
          </Alert>
        )}

        <div className="space-y-1.5">
          <div className="flex items-center justify-between">
            <Label htmlFor="history-date">Date</Label>
            {selected !== today && (
              <button
                type="button"
                onClick={showToday}
                className="text-xs font-medium text-[#0b2a5b] outline-none focus-visible:ring-3 focus-visible:ring-[#0b2a5b]/30"
              >
                Aujourd’hui
              </button>
            )}
          </div>
          <Input
            id="history-date"
            type="date"
            value={toInputValue(selected)}
            max={toInputValue(today)}
            onChange={(e) => onDate(e.target.value)}
            className="h-10 bg-muted/50"
          />
        </div>

        <div className="grid grid-cols-3 gap-3">
          {statStyles.map(({ key, label, icon: Icon }) => (
            <Card key={key} size="sm" className="border-l-4 border-l-[#0b2a5b]">
              <CardHeader className="items-center justify-items-center gap-2 text-center">
                <Icon className="size-5 text-[#0b2a5b]" />
                {rows === null ? (
                  <Skeleton className="h-7 w-8" />
                ) : (
                  <p className="text-2xl font-semibold text-[#0b2a5b] tabular-nums leading-none">{figures[key]}</p>
                )}
                <p className="text-xs font-medium text-muted-foreground">{label}</p>
              </CardHeader>
            </Card>
          ))}
        </div>

        {rows === null && (
          <div className="space-y-2">
            {Array.from({ length: 3 }, (_, index) => (
              <Skeleton key={index} className="h-16 w-full rounded-xl" />
            ))}
          </div>
        )}

        {rows !== null && visible.length === 0 && (
          <div className="rounded-2xl bg-white px-4 py-10 text-center ring-1 ring-[#0b2a5b]/8">
            <p className="font-medium">{searching ? 'Aucun résultat' : 'Aucune visite'}</p>
            <p className="mt-1 text-sm text-muted-foreground">
              {searching ? 'Essayez un autre nom ou une autre ville.' : `Aucun passage le ${fullDate(selected)}.`}
            </p>
          </div>
        )}

        {visible.length > 0 && (
          <section className="space-y-2">
            <div className="flex items-baseline justify-between px-1">
              <h2 className="text-sm font-medium">{dayLabel(selected)}</h2>
              <p className="text-xs text-muted-foreground tabular-nums">
                {plural(visible.length, 'visite', 'visites')}
              </p>
            </div>
            <div className="overflow-hidden rounded-2xl bg-white shadow-[0_8px_24px_rgba(11,42,91,0.05)] ring-1 ring-[#0b2a5b]/8">
              {visible.map((visite, index) => {
                const gifts = visite.cadeaux_qty ?? 0
                return (
                  <Link
                    key={visite.id}
                    to={`/visites/${visite.id}`}
                    state={{ from: '/historique' }}
                    className={cn(
                      'flex items-center gap-3 px-3 py-3 outline-none transition-colors hover:bg-muted/70 focus-visible:bg-muted focus-visible:ring-3 focus-visible:ring-ring/50 focus-visible:ring-inset',
                      index > 0 && 'border-t',
                    )}
                  >
                    <span aria-hidden className="flex size-10 shrink-0 items-center justify-center rounded-full bg-[#0b2a5b]/8 text-sm font-semibold text-[#0b2a5b]">
                      {initials(visite.medecin_name || '')}
                    </span>
                    <span className="min-w-0 flex-1">
                      <span className="flex items-baseline justify-between gap-3">
                        <span className="truncate font-medium">{visite.medecin_name || 'Médecin'}</span>
                        <span className="shrink-0 text-sm text-muted-foreground tabular-nums">{timeLabel(visite.created_at)}</span>
                      </span>
                      <span className="mt-0.5 flex items-center justify-between gap-3">
                        <span className="flex min-w-0 items-center gap-1.5 text-sm text-muted-foreground">
                          <span className="truncate">{placeOf(visite)}</span>
                          {gifts > 0 && (
                            <span className="inline-flex shrink-0 items-center gap-0.5 tabular-nums" aria-label={plural(gifts, 'cadeau', 'cadeaux')}>
                              <Gift className="size-3.5" aria-hidden />
                              {gifts}
                            </span>
                          )}
                        </span>
                        <Badge variant="outline">N°{visite.nvisite}</Badge>
                      </span>
                    </span>
                    <ChevronRight className="size-4 shrink-0 text-muted-foreground" />
                  </Link>
                )
              })}
            </div>
          </section>
        )}
      </div>
    </div>
  )
}
