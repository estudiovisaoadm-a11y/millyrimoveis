export interface Property {
  id: string
  title: string
  slug: string
  description: string
  price: number
  type: "buy" | "rent"
  category: "house" | "apartment" | "land" | "commercial"
  bedrooms: number
  bathrooms: number
  area: number
  parking: number
  address: string
  city: string
  region: string
  neighborhood: string
  latitude: number
  longitude: number
  images: string[]
  featured: boolean
  status: "available" | "sold" | "rented"
  condominium?: Condominium
  amenities: string[]
  createdAt: string
}

export interface Condominium {
  id: string
  name: string
  slug: string
  description: string
  history: string
  infrastructure: string[]
  security: string[]
  distances: { place: string; distance: string }[]
  averagePrice: number
  priceHistory: { year: number; price: number }[]
  images: string[]
  video?: string
  mapUrl?: string
  amenities: string[]
  properties: Property[]
}

export interface Region {
  id: string
  name: string
  slug: string
  headline: string
  description: string
  image: string
  averagePrice: number
  qualityOfLife: {
    schools: { name: string; rating: number }[]
    hospitals: string[]
    restaurants: string[]
    parks: string[]
    gyms: string[]
    markets: string[]
  }
  distances: { place: string; minutes: number }[]
}

export interface BlogPost {
  id: string
  title: string
  slug: string
  excerpt: string
  content: string
  category: string
  image: string
  author: string
  publishedAt: string
  readTime: number
}

export interface MagazinePost extends BlogPost {
  editorialNote?: string
  relatedPosts: string[]
}
