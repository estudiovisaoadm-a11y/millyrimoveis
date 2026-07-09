import Link from "next/link"
import { formatPrice } from "@/lib/utils"
import type { Property } from "@/types"

const mockProperties: Property[] = [
  {
    id: "1",
    title: "Casa contemporânea com vista para o Lago",
    slug: "casa-contemporanea-lago-sul",
    description: "",
    price: 4850000,
    type: "buy",
    category: "house",
    bedrooms: 4,
    bathrooms: 5,
    area: 620,
    parking: 4,
    address: "SHIS QI 11",
    city: "Brasília",
    region: "Lago Sul",
    neighborhood: "QI 11",
    latitude: -15.8267,
    longitude: -47.9218,
    images: [],
    featured: true,
    status: "available",
    amenities: ["Piscina", "Academia", "Home Theater"],
    createdAt: "2026-01-15",
  },
  {
    id: "2",
    title: "Penthouse duplex no Jardim Botânico",
    slug: "penthouse-duplex-jardim-botanico",
    description: "",
    price: 3200000,
    type: "buy",
    category: "apartment",
    bedrooms: 3,
    bathrooms: 3,
    area: 280,
    parking: 3,
    address: "Avenida das Castanheiras",
    city: "Brasília",
    region: "Jardim Botânico",
    neighborhood: "Jardim Botânico",
    latitude: -15.8667,
    longitude: -47.8333,
    images: [],
    featured: true,
    status: "available",
    amenities: ["Vista Panorâmica", "Varanda Gourmet", "4 suítes"],
    createdAt: "2026-02-01",
  },
  {
    id: "3",
    title: "Cobertura com heliponto no Lago Sul",
    slug: "cobertura-heliponto-lago-sul",
    description: "",
    price: 8900000,
    type: "buy",
    category: "apartment",
    bedrooms: 5,
    bathrooms: 6,
    area: 750,
    parking: 6,
    address: "SHIS QI 5",
    city: "Brasília",
    region: "Lago Sul",
    neighborhood: "QI 5",
    latitude: -15.8300,
    longitude: -47.8700,
    images: [],
    featured: true,
    status: "available",
    amenities: ["Heliponto", "Piscina Aquecida", "Spa", "Adega"],
    createdAt: "2026-02-10",
  },
]

export function Destaques() {
  return (
    <section className="py-16 sm:py-24 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-end justify-between mb-12">
          <div>
            <span className="text-xs font-semibold uppercase tracking-widest text-gold-500">
              Exclusividades
            </span>
            <h2 className="text-3xl sm:text-4xl font-bold mt-2">
              Imóveis em destaque
            </h2>
            <p className="text-muted mt-2 max-w-xl">
              Propriedades selecionadas para quem busca o melhor em design,
              localização e sofisticação.
            </p>
          </div>
          <Link
            href="/comprar"
            className="hidden sm:inline-flex text-sm font-medium text-foreground border-b-2 border-foreground pb-0.5 hover:text-brand-600 hover:border-brand-600 transition-colors"
          >
            Ver todos
          </Link>
        </div>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {mockProperties.map((property) => (
            <Link
              key={property.id}
              href={`/imovel/${property.slug}`}
              className="group block"
            >
              <div className="aspect-[4/3] bg-gray-100 rounded-2xl overflow-hidden mb-4">
                <div className="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center text-muted text-sm">
                  Foto do imóvel
                </div>
              </div>
              <div className="space-y-2">
                <div className="flex items-center gap-2 text-xs text-muted uppercase tracking-wider">
                  <span>{property.region}</span>
                  <span className="w-1 h-1 rounded-full bg-gray-300" />
                  <span>{property.bedrooms} dorm</span>
                  <span className="w-1 h-1 rounded-full bg-gray-300" />
                  <span>{property.area}m²</span>
                </div>
                <h3 className="text-lg font-semibold leading-snug group-hover:text-brand-600 transition-colors">
                  {property.title}
                </h3>
                <p className="text-xl font-bold text-foreground">
                  {formatPrice(property.price)}
                </p>
              </div>
            </Link>
          ))}
        </div>
        <div className="mt-8 text-center sm:hidden">
          <Link
            href="/comprar"
            className="inline-flex text-sm font-medium text-foreground border-b-2 border-foreground pb-0.5"
          >
            Ver todos os imóveis
          </Link>
        </div>
      </div>
    </section>
  )
}
