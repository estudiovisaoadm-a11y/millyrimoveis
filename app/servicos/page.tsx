import type { Metadata } from "next"
import { Shield, Home, Scale, FileText, Calculator, Headphones } from "lucide-react"

export const metadata: Metadata = {
  title: "Serviços | MillyR Imóveis",
}

export default function Servicos() {
  return (
    <div className="pt-32 pb-24">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <h1 className="text-4xl sm:text-5xl font-bold mb-4">Serviços</h1>
          <p className="text-muted max-w-xl mx-auto">
            Soluções completas para comprar, vender ou investir em imóveis de alto padrão.
          </p>
        </div>
        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
          {[
            { icon: Home, label: "Compra e Venda", desc: "Assessoria completa na negociação do seu imóvel." },
            { icon: Scale, label: "Avaliação de Imóveis", desc: "Laudo de valor de mercado com metodologia premium." },
            { icon: FileText, label: "Consultoria Jurídica", desc: "Análise documental e suporte jurídico especializado." },
            { icon: Calculator, label: "Simulação Financeira", desc: "Projeções de financiamento e rentabilidade." },
            { icon: Shield, label: "Due Diligence", desc: "Auditoria completa do imóvel antes da compra." },
            { icon: Headphones, label: "Suporte ao Cliente", desc: "Atendimento personalizado do início ao fechamento." },
          ].map((s) => (
            <div key={s.label} className="p-6 bg-white rounded-2xl border border-border hover:shadow-sm transition-shadow">
              <s.icon className="w-6 h-6 text-brand-600 mb-3" />
              <h3 className="font-semibold mb-1">{s.label}</h3>
              <p className="text-sm text-muted">{s.desc}</p>
            </div>
          ))}
        </div>
      </div>
    </div>
  )
}
