import { Hero } from "@/components/home/hero"
import { SearchPremium } from "@/components/home/search-premium"
import { Destaques } from "@/components/home/destaques"
import { RegioesGrid } from "@/components/home/regioes-grid"
import { QualidadeVida } from "@/components/home/qualidade-vida"

export default function Home() {
  return (
    <>
      <Hero />
      <SearchPremium />
      <Destaques />
      <RegioesGrid />
      <QualidadeVida />
    </>
  )
}
