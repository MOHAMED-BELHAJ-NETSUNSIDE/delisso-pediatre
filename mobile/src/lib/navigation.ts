import type { Location, NavigateFunction } from 'react-router-dom'

export function isAppRoot(pathname: string) {
  return pathname === '/' || pathname === '/login'
}

export function goBack(navigate: NavigateFunction, location: Pick<Location, 'key'>, fallback = '/') {
  if (location.key === 'default') navigate(fallback, { replace: true })
  else navigate(-1)
}
