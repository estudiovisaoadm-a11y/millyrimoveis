import type { Metadata } from "next"
import { Heart, Clock, Bell, User } from "lucide-react"

export const metadata: Metadata = {
  title: "Meu Painel | MillyR Imóveis",
}

export default function Dashboard() {
  return (
    <div className="pt-32 pb-24">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 className="text-3xl font-bold mb-8">Meu Painel</h1>
        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
          {[
            { icon: Heart, label: "Favoritos", value: "3 imóveis" },
            { icon: Clock, label: "Últimos vistos", value: "5 imóveis" },
            { icon: Bell, label: "Alertas", value: "2 ativos" },
            { icon: User, label: "Meus dados", value: "Completar" },
          ].map((item) => (
            <div key={item.label} className="p-6 bg-white rounded-2xl border border-border">
              <item.icon className="w-6 h-6 text-brand-600 mb-3" />
              <p className="text-sm text-muted">{item.label}</p>
              <p className="text-lg font-semibold">{item.value}</p>
            </div>
          ))}
        </div>
      </div>
    </div>
  )
}
