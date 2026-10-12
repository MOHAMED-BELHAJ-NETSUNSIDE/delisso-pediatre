import { useEffect, useState } from 'react'
import { Link, useNavigate } from 'react-router-dom'
import { ChevronRight, ClipboardPlus, Gift, History, LogOut, Stethoscope } from 'lucide-react'
import { api, clearAuth, getUser } from '../lib/api'
import type { TodayStats, Visite } from '../lib/api'

const emptyStats: TodayStats = { visites: 0, medecins: 0, cadeaux: 0 }

const roles: Record<string, string> = {
  admin: 'Administrateur',
  gestionnaire: 'Gestionnaire',
  statistiques: 'Statistiques',
  delegue: 'Délégué',
}

const statsMeta = [
  { key: 'visites' as const, label: 'Visites' },
  { key: 'medecins' as const, label: 'Médecins' },
  { key: 'cadeaux' as const, label: 'Cadeaux' },
]

const shortcuts = [
  {
    to: '/historique',
    title: 'Historique',
    description: 'Revoir les visites',
    icon: History,
  },
  {
    to: '/stock',
    title: 'Stock',
    description: 'Cadeaux disponibles',
    icon: Gift,
  },
]

function firstName(name?: string) {
  const trimmed = name?.trim()
  if (!trimmed) return null
  return trimmed.split(/\s+/)[0]
}

function isToday(value: string) {
  const date = new Date(value)
  if (Number.isNaN(date.getTime())) return false
  const now = new Date()
  return date.getFullYear() === now.getFullYear()
    && date.getMonth() === now.getMonth()
    && date.getDate() === now.getDate()
}

function timeLabel(value: string) {
  const date = new Date(value)
  if (Number.isNaN(date.getTime())) return ''
  return new Intl.DateTimeFormat('fr-FR', { hour: '2-digit', minute: '2-digit' }).format(date)
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

export default function HomePage() {
  const user = getUser()
  const nav = useNavigate()
  const [stats, setStats] = useState<TodayStats | null>(null)
  const [visits, setVisits] = useState<Visite[] | null>(null)

  useEffect(() => {
    api.todayStats().then((r) => setStats(r.data)).catch(() => setStats(emptyStats))
    api.visitesMe().then((r) => setVisits(r.data)).catch(() => setVisits([]))
  }, [])

  function logout() {
    clearAuth()
    nav('/login')
  }

  const rawDate = new Intl.DateTimeFormat('fr-FR', {
    weekday: 'long',
    day: 'numeric',
    month: 'long',
  }).format(new Date())
  const dateLabel = rawDate.charAt(0).toUpperCase() + rawDate.slice(1)
  const greetingName = firstName(user?.name)
  const figures = stats ?? emptyStats
  const todayVisits = (visits ?? []).filter((visite) => isToday(visite.created_at)).slice(0, 3)
  const role = roles[user?.role ?? ''] ?? 'Délégué'

  return (
    <div className="mx-auto min-h-full w-full max-w-lg bg-[#f3f6fb]">
      <header className="relative overflow-hidden bg-[linear-gradient(135deg,#071a38_0%,#0b2a5b_58%,#16407f_100%)] px-5 pt-5 pb-6 text-white">
        <div
          aria-hidden
          className="pointer-events-none absolute -top-16 right-0 size-48 rounded-full bg-[#e31c23]/35 blur-3xl"
        />

        <div className="relative flex items-start justify-between gap-3">
          <p className="text-[0.7rem] font-bold tracking-[0.16em] text-[#f3b4b6] uppercase">
            Tournée pédiatre
          </p>
          <button
            type="button"
            onClick={logout}
            className="inline-flex shrink-0 items-center gap-1.5 rounded-full border border-white/15 bg-white/10 px-2.5 py-1 text-xs text-white outline-none hover:bg-white/15 focus-visible:ring-3 focus-visible:ring-white/50"
          >
            <LogOut className="size-3.5" />
            Sortir
          </button>
        </div>

        <h1 className="relative mt-2 text-[1.7rem] leading-tight font-bold tracking-tight">
          {greetingName ? `Bonjour, ${greetingName}` : 'Bonjour'}
        </h1>
        <p className="relative mt-1 max-w-xs text-sm text-[#c5d0de]">
          Vos visites et cadeaux du jour.
        </p>
        <p className="relative mt-3 flex flex-wrap gap-2">
          <span className="rounded-full border border-white/15 bg-white/10 px-2.5 py-1 text-xs">{role}</span>
          <span className="rounded-full border border-white/15 bg-white/10 px-2.5 py-1 text-xs">{dateLabel}</span>
        </p>

        <div className="relative mt-5 grid grid-cols-3 gap-2">
          {statsMeta.map(({ key, label }) => (
            <div key={key} className="rounded-2xl border border-white/15 bg-white/10 px-2 py-3 text-center">
              {stats === null ? (
                <span className="mx-auto block h-7 w-8 animate-pulse rounded-md bg-white/20" />
              ) : (
                <p className="text-2xl font-bold tabular-nums leading-none">{figures[key]}</p>
              )}
              <p className="mt-1.5 text-[0.7rem] text-[#c5d0de]">{label}</p>
            </div>
          ))}
        </div>
      </header>

      <div className="space-y-6 px-4 py-5">
        <section className="space-y-3">
          <Link
            to="/visite"
            className="flex items-center gap-3 rounded-2xl bg-[#0b2a5b] p-4 text-white shadow-[0_12px_28px_rgba(11,42,91,0.18)] outline-none focus-visible:ring-3 focus-visible:ring-[#0b2a5b]/40"
          >
            <span className="flex size-11 shrink-0 items-center justify-center rounded-xl bg-white/10">
              <ClipboardPlus className="size-5" />
            </span>
            <span className="min-w-0 flex-1">
              <span className="block font-semibold">Nouvelle visite</span>
              <span className="block text-sm text-white/75">Enregistrer un passage</span>
            </span>
            <ChevronRight className="size-5 shrink-0 text-white/70" />
          </Link>

          <div className="grid grid-cols-2 gap-3">
            {shortcuts.map(({ to, title, description, icon: Icon }) => (
              <Link
                key={to}
                to={to}
                className="rounded-2xl bg-white p-4 shadow-[0_8px_24px_rgba(11,42,91,0.05)] ring-1 ring-[#0b2a5b]/8 outline-none focus-visible:ring-3 focus-visible:ring-[#0b2a5b]/30"
              >
                <span className="flex size-9 items-center justify-center rounded-xl bg-[#0b2a5b]/8 text-[#0b2a5b]">
                  <Icon className="size-4" />
                </span>
                <span className="mt-3 block font-semibold text-[#0b2a5b]">{title}</span>
                <span className="mt-0.5 block text-sm text-[#5b6b7c]">{description}</span>
              </Link>
            ))}
          </div>
        </section>

        <section className="space-y-2">
          <div className="flex items-baseline justify-between px-1">
            <h2 className="text-sm font-semibold text-[#0b2a5b]">Aujourd’hui</h2>
            <Link
              to="/historique"
              className="text-xs font-medium text-[#0b2a5b] outline-none focus-visible:ring-3 focus-visible:ring-[#0b2a5b]/30"
            >
              Tout voir
            </Link>
          </div>

          {visits === null && (
            <div className="space-y-2">
              {Array.from({ length: 2 }, (_, index) => (
                <div key={index} className="h-16 animate-pulse rounded-2xl bg-white ring-1 ring-[#0b2a5b]/8" />
              ))}
            </div>
          )}

          {visits !== null && todayVisits.length === 0 && (
            <div className="rounded-2xl bg-white px-4 py-8 text-center ring-1 ring-[#0b2a5b]/8">
              <Stethoscope className="mx-auto size-5 text-[#0b2a5b]/50" />
              <p className="mt-2 font-medium text-[#0b2a5b]">Aucune visite</p>
              <p className="mt-1 text-sm text-[#5b6b7c]">Les passages d’aujourd’hui apparaîtront ici.</p>
            </div>
          )}

          {todayVisits.length > 0 && (
            <div className="overflow-hidden rounded-2xl bg-white ring-1 ring-[#0b2a5b]/8">
              {todayVisits.map((visite, index) => {
                const gifts = visite.cadeaux_qty ?? 0
                return (
                  <Link
                    key={visite.id}
                    to={`/visites/${visite.id}`}
                    state={{ from: '/' }}
                    className={`flex items-center gap-3 px-3 py-3 outline-none hover:bg-[#f3f6fb] focus-visible:bg-[#f3f6fb] focus-visible:ring-3 focus-visible:ring-[#0b2a5b]/30 focus-visible:ring-inset ${index > 0 ? 'border-t border-[#0b2a5b]/8' : ''}`}
                  >
                    <span className="flex size-10 shrink-0 items-center justify-center rounded-full bg-[#0b2a5b]/8 text-sm font-semibold text-[#0b2a5b]">
                      {initials(visite.medecin_name || '')}
                    </span>
                    <span className="min-w-0 flex-1">
                      <span className="flex items-baseline justify-between gap-3">
                        <span className="truncate font-medium text-[#1a2332]">{visite.medecin_name || 'Médecin'}</span>
                        <span className="shrink-0 text-sm text-[#5b6b7c] tabular-nums">{timeLabel(visite.created_at)}</span>
                      </span>
                      <span className="mt-0.5 flex items-center gap-2 text-sm text-[#5b6b7c]">
                        <span className="truncate">{placeOf(visite)}</span>
                        {gifts > 0 && (
                          <span className="inline-flex shrink-0 items-center gap-0.5 tabular-nums">
                            <Gift className="size-3.5" />
                            {gifts}
                          </span>
                        )}
                      </span>
                    </span>
                    <ChevronRight className="size-4 shrink-0 text-[#5b6b7c]" />
                  </Link>
                )
              })}
            </div>
          )}
        </section>
      </div>
    </div>
  )
}
