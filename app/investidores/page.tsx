import type { Metadata } from "next"
import { TrendingUp, BarChart3, PieChart, LineChart } from "lucide-react"

export const metadata: Metadata = {
  title: "Investidores | MillyR Imóveis",
}

export default function Investidores() {
  return (
    <div className="pt-32 pb-24">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <span className="text-xs font-semibold uppercase tracking-widest text-gold-500">
            Inteligência de Mercado
          </span>
          <h1 className="text-4xl sm:text-5xl font-bold mt-2 mb-4">Investidores</h1>
          <p className="text-muted max-w-2xl mx-auto">
            Dados, análises e indicadores para decisões de investimento
            imobiliário em Brasília.
          </p>
        </div>
        <div className="grid sm:grid-cols-2 gap-8 mb-16">
          {[
            { icon: TrendingUp, label: "Valorização", desc: "Acompanhe a evolução de preços por região nos últimos 5 anos." },
            { icon: BarChart3, label: "Rentabilidade", desc: "Comparativo de retorno entre aluguel e venda por bairro." },
            { icon: PieChart, label: "Comparativo", desc: "Análise de desempenho entre diferentes categorias de imóvel." },
            { icon: LineChart, label: "Indicadores", desc: "IPO, VGV, estoque e velocidade de venda do mercado local." },
          ].map((item) => (
            <div key={item.label} className="p-8 bg-white rounded-2xl border border-border">
              <item.icon className="w-8 h-8 text-brand-600 mb-4" />
              <h3 className="text-lg font-semibold mb-2">{item.label}</h3>
              <p className="text-sm text-muted">{item.desc}</p>
            </div>
          ))}
        </div>
        <div className="p-8 bg-gray-50 rounded-2xl border border-border text-center">
          <p className="text-muted text-sm mb-4">Gráficos e dashboards serão renderizados aqui com Recharts</p>
          <div className="h-64 bg-white rounded-xl border border-border flex items-center justify-center text-muted text-sm">
            Dashboard de Indicadores
          </div>
        </div>
      </div>
    </div>
  )
}
