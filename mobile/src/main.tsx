import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import { BrowserRouter } from 'react-router-dom'
import { Capacitor, SystemBarType, SystemBars } from '@capacitor/core'
import './index.css'
import App from './App.tsx'

if (Capacitor.isNativePlatform()) {
  void SystemBars.hide({ bar: SystemBarType.StatusBar })
}

createRoot(document.getElementById('root')!).render(
  <StrictMode>
    <BrowserRouter>
      <App />
    </BrowserRouter>
  </StrictMode>,
)
