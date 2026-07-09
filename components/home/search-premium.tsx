"use client"

import { Search, MapPin, SlidersHorizontal } from "lucide-react"
import { useState } from "react"

export function SearchPremium() {
  const [purpose, setPurpose] = useState<"buy" | "rent">("buy")

  return (
    <section className="py-16 sm:py-24">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="bg-white rounded-2xl shadow-sm border border-border p-6 sm:p-8">
          <div className="flex gap-4 mb-6">
            <button
              onClick={() => setPurpose("buy")}
              className={`px-6 py-2 rounded-full text-sm font-medium transition-all ${
                purpose === "buy"
                  ? "bg-foreground text-white"
                  : "bg-gray-100 text-muted hover:bg-gray-200"
              }`}
            >
              Comprar
            </button>
            <button
              onClick={() => setPurpose("rent")}
              className={`px-6 py-2 rounded-full text-sm font-medium transition-all ${
                purpose === "rent"
                  ? "bg-foreground text-white"
                  : "bg-gray-100 text-muted hover:bg-gray-200"
              }`}
            >
              Alugar
            </button>
          </div>
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div className="relative">
              <MapPin className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted" />
              <select className="w-full h-12 pl-10 pr-4 rounded-xl border border-border bg-white text-sm appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-500">
                <option value="">Cidade</option>
                <option>Brasília</option>
              </select>
            </div>
            <div className="relative">
              <MapPin className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted" />
              <select className="w-full h-12 pl-10 pr-4 rounded-xl border border-border bg-white text-sm appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-500">
                <option value="">Região</option>
                <option>Jardim Botânico</option>
                <option>Lago Sul</option>
                <option>Asa Sul</option>
                <option>Noroeste</option>
                <option>Águas Claras</option>
              </select>
            </div>
            <div className="relative">
              <select className="w-full h-12 px-4 rounded-xl border border-border bg-white text-sm appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-500">
                <option value="">Valor</option>
                <option>Até R$ 500 mil</option>
                <option>R$ 500 mil - R$ 1 milhão</option>
                <option>R$ 1 milhão - R$ 3 milhões</option>
                <option>Acima de R$ 3 milhões</option>
              </select>
            </div>
            <div className="relative">
              <select className="w-full h-12 px-4 rounded-xl border border-border bg-white text-sm appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-brand-500">
                <option value="">Dormitórios</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4+</option>
              </select>
            </div>
            <button className="h-12 bg-foreground text-white rounded-xl font-medium hover:bg-foreground/90 transition-colors flex items-center justify-center gap-2">
              <Search className="w-4 h-4" />
              Buscar
            </button>
          </div>
        </div>
      </div>
    </section>
  )
}
