import { useEffect, useId, useRef, useState } from 'react'
import type { KeyboardEvent } from 'react'
import { Search, X } from 'lucide-react'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Spinner } from '@/components/ui/spinner'
import { api, type Medecin } from '../lib/api'

type Props = {
  selected: Medecin | null
  onSelect: (medecin: Medecin | null) => void
}

function isAbort(err: unknown): boolean {
  return (err instanceof DOMException || err instanceof Error) && err.name === 'AbortError'
}

function placeOf(medecin: Medecin): string {
  if (medecin.municipalite && medecin.region && medecin.municipalite !== medecin.region) {
    return `${medecin.municipalite}, ${medecin.region}`
  }
  return medecin.municipalite || medecin.region || ''
}

function detailOf(medecin: Medecin): string {
  return [placeOf(medecin), medecin.name_etab, medecin.tel].filter(Boolean).join(' · ')
}

export default function MedecinSearch({ selected, onSelect }: Props) {
  const listId = useId()
  const boxRef = useRef<HTMLDivElement>(null)
  const inputRef = useRef<HTMLInputElement>(null)
  const [q, setQ] = useState('')
  const [results, setResults] = useState<Medecin[]>([])
  const [open, setOpen] = useState(false)
  const [searching, setSearching] = useState(false)
  const [searchError, setSearchError] = useState('')
  const [settledTerm, setSettledTerm] = useState('')
  const [active, setActive] = useState(0)

  const term = q.trim()
  const showList = open && term.length >= 2

  useEffect(() => {
    if (term.length < 2) {
      setResults([])
      setSearching(false)
      setSearchError('')
      setSettledTerm('')
      return
    }

    const ctrl = new AbortController()
    setResults([])
    setSearching(true)
    setSearchError('')
    const timer = setTimeout(() => {
      api.medecins(term, ctrl.signal)
        .then((r) => {
          setResults(r.data)
          setSettledTerm(term)
          setActive(0)
        })
        .catch((err) => {
          if (isAbort(err)) return
          setResults([])
          setSettledTerm(term)
          setSearchError(err instanceof Error ? err.message : 'Recherche impossible')
        })
        .finally(() => {
          if (!ctrl.signal.aborted) setSearching(false)
        })
    }, 200)

    return () => {
      clearTimeout(timer)
      ctrl.abort()
    }
  }, [term])

  useEffect(() => {
    function onPointerDown(event: PointerEvent) {
      if (!boxRef.current?.contains(event.target as Node)) setOpen(false)
    }
    document.addEventListener('pointerdown', onPointerDown)
    return () => document.removeEventListener('pointerdown', onPointerDown)
  }, [])

  useEffect(() => {
    if (!showList) return
    const current = results[active]
    if (!current) return
    document.getElementById(`${listId}-${current.id}`)?.scrollIntoView({ block: 'nearest' })
  }, [active, listId, results, showList])

  function choose(medecin: Medecin) {
    onSelect(medecin)
    setQ('')
    setResults([])
    setOpen(false)
  }

  function onKeyDown(event: KeyboardEvent<HTMLInputElement>) {
    if (!showList) return
    if (event.key === 'ArrowDown') {
      event.preventDefault()
      setActive((i) => Math.min(i + 1, Math.max(results.length - 1, 0)))
    } else if (event.key === 'ArrowUp') {
      event.preventDefault()
      setActive((i) => Math.max(i - 1, 0))
    } else if (event.key === 'Enter') {
      event.preventDefault()
      if (results[active]) choose(results[active])
    } else if (event.key === 'Escape') {
      setOpen(false)
    }
  }

  return (
    <div ref={boxRef} className="space-y-2">
      <Label htmlFor="medecin-search">Recherche</Label>
      <div className="relative">
        <Search className="pointer-events-none absolute top-1/2 left-2.5 size-4 -translate-y-1/2 text-muted-foreground" />
        <Input
          ref={inputRef}
          id="medecin-search"
          className="h-10 pr-9 pl-8"
          placeholder="Nom, ville, établissement, téléphone…"
          value={q}
          autoComplete="off"
          role="combobox"
          aria-expanded={showList}
          aria-controls={listId}
          aria-autocomplete="list"
          aria-activedescendant={showList && results[active] ? `${listId}-${results[active].id}` : undefined}
          onChange={(e) => {
            setQ(e.target.value)
            setOpen(true)
          }}
          onFocus={() => setOpen(true)}
          onKeyDown={onKeyDown}
        />
        {searching && <Spinner className="absolute top-1/2 right-2.5 -translate-y-1/2" />}
      </div>

      {term.length === 1 && (
        <p className="text-xs text-muted-foreground">Saisissez au moins 2 caractères</p>
      )}
      {searchError && <p className="text-xs text-destructive">{searchError}</p>}

      {showList && (
        <div id={listId} role="listbox" className="max-h-64 overflow-auto rounded-2xl border border-[#0b2a5b]/10 bg-white shadow-[0_8px_24px_rgba(11,42,91,0.08)]">
          {settledTerm !== term && results.length === 0 && (
            <p className="px-3 py-4 text-sm text-muted-foreground">Recherche…</p>
          )}
          {settledTerm === term && !searchError && results.length === 0 && (
            <p className="px-3 py-4 text-sm text-muted-foreground">Aucun médecin trouvé</p>
          )}
          {results.map((medecin, index) => (
            <button
              key={medecin.id}
              id={`${listId}-${medecin.id}`}
              type="button"
              role="option"
              aria-selected={index === active}
              className={`flex w-full flex-col gap-0.5 border-b px-3 py-2.5 text-left last:border-b-0 ${index === active ? 'bg-[#0b2a5b]/10 text-[#0b2a5b]' : 'hover:bg-[#f3f6fb]'}`}
              onMouseEnter={() => setActive(index)}
              onMouseDown={(e) => e.preventDefault()}
              onClick={() => choose(medecin)}
            >
              <span className="text-sm font-medium">{medecin.fullname}</span>
              {detailOf(medecin) && (
                <span className="text-xs text-[#5b6b7c]">{detailOf(medecin)}</span>
              )}
            </button>
          ))}
          {results.length === 30 && (
            <p className="px-3 py-2 text-xs text-muted-foreground">Affinez la recherche pour voir les autres résultats</p>
          )}
        </div>
      )}

      {selected && (
        <div className="flex items-start justify-between gap-2 rounded-2xl border border-[#0b2a5b]/10 bg-[#0b2a5b]/5 p-3">
          <div className="min-w-0 text-sm">
            <div className="font-medium">{selected.fullname}</div>
            {detailOf(selected) && (
              <div className="text-xs text-muted-foreground">{detailOf(selected)}</div>
            )}
          </div>
          <Button
            type="button"
            variant="ghost"
            size="icon-xs"
            aria-label="Retirer le médecin"
            onClick={() => {
              onSelect(null)
              inputRef.current?.focus()
            }}
          >
            <X />
          </Button>
        </div>
      )}
    </div>
  )
}
