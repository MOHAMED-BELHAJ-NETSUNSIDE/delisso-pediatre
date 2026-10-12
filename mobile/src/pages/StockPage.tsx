import { useEffect, useState } from 'react'
import { Gift } from 'lucide-react'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { Badge } from '@/components/ui/badge'
import { Card, CardContent } from '@/components/ui/card'
import PageHeader from '../components/PageHeader'
import { api, mediaUrl } from '../lib/api'
import type { Cadeau } from '../lib/api'

export default function StockPage() {
  const [rows, setRows] = useState<Cadeau[] | null>(null)
  const [error, setError] = useState('')

  useEffect(() => {
    api.cadeaux()
      .then((r) => setRows(r.data))
      .catch((e) => {
        setRows([])
        setError(e instanceof Error ? e.message : 'Erreur')
      })
  }, [])

  return (
    <div className="mx-auto min-h-full w-full max-w-lg">
      <PageHeader title="Stock des cadeaux" />
      <div className="space-y-4 p-4">
      {error && (
        <Alert variant="destructive">
          <AlertDescription>{error}</AlertDescription>
        </Alert>
      )}
      {rows === null && (
        <div className="space-y-2">
          {Array.from({ length: 3 }, (_, index) => (
            <div key={index} className="h-20 animate-pulse rounded-2xl bg-white ring-1 ring-[#0b2a5b]/8" />
          ))}
        </div>
      )}
      {rows?.length === 0 && !error && (
        <div className="rounded-2xl bg-white px-4 py-10 text-center ring-1 ring-[#0b2a5b]/8">
          <Gift className="mx-auto size-5 text-[#0b2a5b]/50" />
          <p className="mt-2 font-medium text-[#0b2a5b]">Aucun cadeau</p>
          <p className="mt-1 text-sm text-[#5b6b7c]">Le stock apparaîtra ici.</p>
        </div>
      )}
      <div className="space-y-2">
        {(rows ?? []).map((cadeau) => {
          const image = mediaUrl(cadeau.image_url)
          const low = cadeau.stock <= cadeau.seuil_alerte
          return (
            <Card key={cadeau.id} size="sm">
              <CardContent className="flex items-center gap-3">
                {image ? (
                  <img src={image} alt={cadeau.name} className="size-14 shrink-0 rounded-lg object-cover" />
                ) : (
                  <div className="flex size-14 shrink-0 items-center justify-center rounded-xl bg-[#0b2a5b]/8 text-[#0b2a5b]">
                    <Gift />
                  </div>
                )}
                <div className="min-w-0 flex-1">
                  <div className="truncate font-medium">{cadeau.name}</div>
                  <div className="text-sm text-muted-foreground tabular-nums">Stock {cadeau.stock}</div>
                </div>
                {low && <Badge variant="destructive">Stock bas</Badge>}
              </CardContent>
            </Card>
          )
        })}
      </div>
      </div>
    </div>
  )
}
