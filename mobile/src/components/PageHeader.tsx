import type { ReactNode } from 'react'
import { useLocation, useNavigate } from 'react-router-dom'
import { ChevronLeft } from 'lucide-react'
import { Button } from '@/components/ui/button'
import { goBack } from '../lib/navigation'

export default function PageHeader({
  title,
  subtitle,
  fallback = '/',
  children,
}: {
  title: string
  subtitle?: string
  fallback?: string
  children?: ReactNode
}) {
  const navigate = useNavigate()
  const location = useLocation()

  return (
    <header className="sticky top-0 z-10 bg-[linear-gradient(135deg,#071a38_0%,#0b2a5b_70%,#16407f_100%)] text-white">
      <div className="flex items-center gap-1 py-3 pr-3 pl-2">
        <Button
          type="button"
          variant="ghost"
          size="icon"
          aria-label="Retour"
          className="text-white hover:bg-white/10 hover:text-white"
          onClick={() => goBack(navigate, location, fallback)}
        >
          <ChevronLeft />
        </Button>
        <div className="min-w-0 flex-1">
          <h1 className="truncate text-base font-semibold leading-tight">{title}</h1>
          {subtitle && <p className="truncate text-sm text-[#c5d0de]">{subtitle}</p>}
        </div>
      </div>
      {children}
    </header>
  )
}
