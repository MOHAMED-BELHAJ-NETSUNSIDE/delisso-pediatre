const API_URL = (import.meta.env.VITE_API_URL as string) || ''

export type User = { id: number; name: string; email: string; role: string }

function token(): string | null {
  return localStorage.getItem('danino_token')
}

export function setAuth(t: string, user: User) {
  localStorage.setItem('danino_token', t)
  localStorage.setItem('danino_user', JSON.stringify(user))
}

export function clearAuth() {
  localStorage.removeItem('danino_token')
  localStorage.removeItem('danino_user')
}

export function getUser(): User | null {
  const raw = localStorage.getItem('danino_user')
  if (!raw) return null
  try {
    return JSON.parse(raw) as User
  } catch {
    return null
  }
}

async function request<T>(path: string, options: RequestInit = {}): Promise<T> {
  const headers = new Headers(options.headers || {})
  const t = token()
  if (t) headers.set('Authorization', `Bearer ${t}`)
  if (!(options.body instanceof FormData) && !headers.has('Content-Type')) {
    headers.set('Content-Type', 'application/json')
  }

  let res: Response
  try {
    res = await fetch(`${API_URL}${path}`, { ...options, headers })
  } catch {
    throw new Error('Impossible de contacter le serveur')
  }
  const data = await res.json().catch(() => ({}))
  if (!res.ok) {
    throw new Error(data.error || `Erreur ${res.status}`)
  }
  return data as T
}

export const api = {
  login: (email: string, password: string) =>
    request<{ token: string; user: User }>('/api/auth/login', {
      method: 'POST',
      body: JSON.stringify({ email, password }),
    }),
  medecins: (q = '', signal?: AbortSignal) =>
    request<{ data: Medecin[] }>(`/api/medecins?q=${encodeURIComponent(q)}`, { signal }),
  medecin: (id: number) => request<{ data: Medecin }>(`/api/medecins/${id}`),
  createMedecin: (body: Partial<Medecin>) =>
    request<{ id: number }>('/api/medecins', { method: 'POST', body: JSON.stringify(body) }),
  cadeaux: () => request<{ data: Cadeau[] }>('/api/cadeaux'),
  visitesMe: () => request<{ data: Visite[] }>('/api/visites/me'),
  todayStats: () => request<{ data: TodayStats }>('/api/visites/me/today'),
  visite: (id: number) => request<{ data: VisiteDetail }>(`/api/visites/me/${id}`),
  createVisite: (form: FormData) =>
    request<{ id: number; message: string }>('/api/visites', { method: 'POST', body: form }),
}

export type Medecin = {
  id: number
  fullname: string
  type: number
  region?: string
  municipalite?: string
  etab?: number
  name_etab?: string
  adresse?: string
  tel?: string
  email?: string
  classe?: string
}

export type Cadeau = {
  id: number
  name: string
  image_path?: string | null
  image_url?: string | null
  stock: number
  seuil_alerte: number
}

export type TodayStats = {
  visites: number
  medecins: number
  cadeaux: number
}

export type Visite = {
  id: number
  medecin_name: string
  nvisite: number
  created_at: string
  region?: string | null
  municipalite?: string | null
  cadeaux_qty?: number
}

export type VisiteDetail = Visite & {
  classe?: string | null
  municipalite?: string | null
  etab?: string | null
  name_etab?: string | null
  gps?: string | null
  remarque?: string | null
  cadeaux: { name: string | null; qty: number }[]
  photos: { url: string; content?: string | null }[]
}

export function formatDate(value: string): string {
  const date = new Date(value)
  if (Number.isNaN(date.getTime())) return value
  return new Intl.DateTimeFormat('fr-FR', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  }).format(date)
}

export function mediaUrl(url?: string | null): string | null {
  if (!url) return null
  const path = url.startsWith('http') ? new URL(url).pathname : url
  const mediaPath = path.startsWith('/storage/')
    ? `/media/${path.slice('/storage/'.length)}`
    : path
  if (mediaPath.startsWith('/media/')) {
    return `${API_URL.replace(/\/$/, '')}${mediaPath}`
  }
  return url
}
