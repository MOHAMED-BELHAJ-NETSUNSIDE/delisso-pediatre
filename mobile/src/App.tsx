import { Navigate, Route, Routes } from 'react-router-dom'
import NativeBack from './components/NativeBack'
import { getUser } from './lib/api'
import HomePage from './pages/HomePage'
import LoginPage from './pages/LoginPage'
import VisitePage from './pages/VisitePage'
import HistoryPage from './pages/HistoryPage'
import StockPage from './pages/StockPage'
import VisiteDetailPage from './pages/VisiteDetailPage'

function Private({ children }: { children: React.ReactNode }) {
  if (!getUser()) return <Navigate to="/login" replace />
  return <>{children}</>
}

export default function App() {
  return (
    <>
      <NativeBack />
      <Routes>
      <Route path="/login" element={<LoginPage />} />
      <Route path="/" element={<Private><HomePage /></Private>} />
      <Route path="/visite" element={<Private><VisitePage /></Private>} />
      <Route path="/historique" element={<Private><HistoryPage /></Private>} />
      <Route path="/stock" element={<Private><StockPage /></Private>} />
      <Route path="/visites/:id" element={<Private><VisiteDetailPage /></Private>} />
      <Route path="*" element={<Navigate to="/" replace />} />
      </Routes>
    </>
  )
}
