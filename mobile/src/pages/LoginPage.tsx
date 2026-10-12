import { useState } from 'react'
import type { FormEvent } from 'react'
import { Navigate, useNavigate } from 'react-router-dom'
import { Alert, AlertDescription } from '@/components/ui/alert'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import logo from '@/assets/logo-mobile.png'
import { api, getUser, setAuth } from '../lib/api'

export default function LoginPage() {
  const nav = useNavigate()
  const [email, setEmail] = useState('')
  const [password, setPassword] = useState('')
  const [error, setError] = useState('')
  const [loading, setLoading] = useState(false)

  if (getUser()) return <Navigate to="/" replace />

  async function onSubmit(e: FormEvent) {
    e.preventDefault()
    setLoading(true)
    setError('')
    try {
      const res = await api.login(email, password)
      setAuth(res.token, res.user)
      nav('/', { replace: true })
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Erreur de connexion')
    } finally {
      setLoading(false)
    }
  }

  return (
    <div className="relative flex min-h-full items-center justify-center overflow-hidden bg-[linear-gradient(160deg,#071a38_0%,#0b2a5b_55%,#16407f_100%)] p-4">
      <div
        aria-hidden
        className="pointer-events-none absolute -top-24 right-0 size-64 rounded-full bg-[#e31c23]/30 blur-3xl"
      />

      <div className="relative w-full max-w-sm">
        <div className="mb-6 text-center text-white">
          <img
            src={logo}
            alt="Délisso"
            className="mx-auto mb-4 h-auto w-full max-w-56 rounded-2xl object-contain ring-1 ring-white/20"
          />
          <p className="text-[0.7rem] font-bold tracking-[0.16em] text-[#f3b4b6] uppercase">Tournée pédiatre</p>
          <h1 className="mt-2 text-2xl font-bold tracking-tight">Connexion délégué</h1>
          <p className="mt-1 text-sm text-[#c5d0de]">Enregistrez vos visites et vos cadeaux.</p>
        </div>

        <form onSubmit={onSubmit} className="space-y-3 rounded-2xl bg-white p-5 shadow-[0_18px_40px_rgba(7,26,56,0.28)]">
          {error && (
            <Alert variant="destructive">
              <AlertDescription>{error}</AlertDescription>
            </Alert>
          )}
          <div className="space-y-1.5">
            <Label htmlFor="email">Email</Label>
            <Input id="email" type="email" value={email} onChange={(e) => setEmail(e.target.value)} className="h-10 bg-[#f3f6fb]" required />
          </div>
          <div className="space-y-1.5">
            <Label htmlFor="password">Mot de passe</Label>
            <Input id="password" type="password" value={password} onChange={(e) => setPassword(e.target.value)} className="h-10 bg-[#f3f6fb]" required />
          </div>
          <Button disabled={loading} className="mt-1 h-11 w-full rounded-xl text-base" type="submit">
            {loading ? 'Connexion…' : 'Se connecter'}
          </Button>
        </form>
      </div>
    </div>
  )
}
