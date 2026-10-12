import { useEffect, useRef } from 'react'
import { useLocation, useNavigate } from 'react-router-dom'
import { App } from '@capacitor/app'
import { Capacitor, type PluginListenerHandle } from '@capacitor/core'
import { goBack, isAppRoot } from '../lib/navigation'

function fallbackFor(pathname: string) {
  if (pathname.startsWith('/visites/')) return '/historique'
  return '/'
}

export default function NativeBack() {
  const navigate = useNavigate()
  const location = useLocation()
  const locationRef = useRef(location)
  locationRef.current = location

  useEffect(() => {
    if (!Capacitor.isNativePlatform()) return

    let removed = false
    let handle: PluginListenerHandle | undefined

    void App.addListener('backButton', () => {
      const current = locationRef.current
      if (isAppRoot(current.pathname)) {
        void App.exitApp()
        return
      }
      goBack(navigate, current, fallbackFor(current.pathname))
    }).then((listener) => {
      if (removed) void listener.remove()
      else handle = listener
    })

    return () => {
      removed = true
      void handle?.remove()
    }
  }, [navigate])

  return null
}
