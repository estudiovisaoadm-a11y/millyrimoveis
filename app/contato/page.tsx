import type { Metadata } from "next"

export const metadata: Metadata = {
  title: "Contato | MillyR Imóveis",
}

export default function Contato() {
  return (
    <div className="pt-32 pb-24">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <h1 className="text-4xl sm:text-5xl font-bold mb-4">Contato</h1>
          <p className="text-muted max-w-xl mx-auto">
            Pronto para encontrar o imóvel dos seus sonhos? Fale conosco.
          </p>
        </div>
        <div className="grid md:grid-cols-2 gap-12">
          <div className="space-y-6">
            <div>
              <h3 className="text-sm font-semibold uppercase tracking-wider text-muted mb-1">Endereço</h3>
              <p>SHIS QI 11, Brasília - DF, 71625-200</p>
            </div>
            <div>
              <h3 className="text-sm font-semibold uppercase tracking-wider text-muted mb-1">Telefone</h3>
              <p>(61) 99999-9999</p>
            </div>
            <div>
              <h3 className="text-sm font-semibold uppercase tracking-wider text-muted mb-1">E-mail</h3>
              <p>contato@millyrimoveis.com.br</p>
            </div>
            <div>
              <h3 className="text-sm font-semibold uppercase tracking-wider text-muted mb-1">Horário</h3>
              <p>Seg a Sex: 9h - 19h | Sáb: 9h - 13h</p>
            </div>
          </div>
          <form className="space-y-4">
            <div className="grid sm:grid-cols-2 gap-4">
              <input type="text" placeholder="Nome" className="w-full h-12 px-4 rounded-xl border border-border bg-white text-sm focus:outline-none focus:ring-2 focus:ring-brand-500" />
              <input type="email" placeholder="E-mail" className="w-full h-12 px-4 rounded-xl border border-border bg-white text-sm focus:outline-none focus:ring-2 focus:ring-brand-500" />
            </div>
            <input type="tel" placeholder="Telefone" className="w-full h-12 px-4 rounded-xl border border-border bg-white text-sm focus:outline-none focus:ring-2 focus:ring-brand-500" />
            <textarea placeholder="Mensagem" rows={4} className="w-full px-4 py-3 rounded-xl border border-border bg-white text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 resize-none" />
            <button type="submit" className="w-full h-12 bg-foreground text-white rounded-xl font-medium hover:bg-foreground/90 transition-colors">
              Enviar mensagem
            </button>
          </form>
        </div>
      </div>
    </div>
  )
}
