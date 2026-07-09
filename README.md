# MillyR Imóveis — Plataforma Next.js

Plataforma imobiliária premium para Brasília, focada em alto padrão (Jardim Botânico, Lago Sul, Asa Sul). Posiciona a MillyR como **consultoria imobiliária**, não apenas um portal de anúncios.

## Stack

| Camada | Tecnologia |
|--------|-----------|
| Framework | Next.js 15 (App Router) |
| UI | React 19 + Tailwind CSS v4 |
| Componentes | shadcn/ui |
| Animações | Framer Motion |
| Database | PostgreSQL + Prisma ORM |
| Autenticação | Auth.js (NextAuth v5) |
| IA | OpenAI GPT-4o |
| Upload | Cloudinary |
| Mapas | Google Maps API |
| E-mail | Resend |
| Deploy | Vercel (frontend) + Hostinger (WordPress legado) |

## Branches

| Branch | Finalidade |
|--------|-----------|
| `master` | WordPress legado — public_html (deploy automático Hostinger) |
| `source` | Clone do WordPress para referência |
| `nextjs` | **Nova plataforma** — código fonte Next.js (esta branch) |

## Estrutura

```
app/
├── page.tsx              # Home (Hero + Busca + Destaques + Regiões + Qualidade de Vida)
├── quem-somos/           # Institucional
├── comprar/              # Imóveis à venda
├── alugar/               # Imóveis para alugar
├── lancamentos/          # Empreendimentos novos
├── condominios/          # Guia completo de condomínios (SEO)
├── regioes/              # Guia de regiões (escolas, hospitais, etc.)
├── revista/              # Conteúdo editorial (blog premium)
├── investidores/         # Dashboard com indicadores e gráficos
├── servicos/             # Serviços oferecidos
├── contato/              # Formulário + informações
├── imovel/[id]/          # Landing page do imóvel
├── dashboard/            # Área do cliente
└── api/                  # API routes (properties, contact, search, ai)
components/
├── layout/               # Header, Footer
├── home/                 # Hero, SearchPremium, Destaques, RegioesGrid, QualidadeVida
├── imovel/               # Componentes da página do imóvel
└── ui/                   # shadcn/ui primitives
lib/                      # Utilitários, Prisma client, OpenAI
prisma/                   # Schema do banco
types/                    # Tipos TypeScript
```

## Funcionalidades planejadas

- [x] Home premium com hero fullscreen
- [x] Busca inteligente com IA
- [x] Páginas de imóveis como landing pages
- [x] Guia completo de condomínios
- [x] Guia de regiões com qualidade de vida
- [x] Revista com conteúdo editorial
- [x] Área do investidor com indicadores
- [ ] Comparador de imóveis
- [ ] Assistente IA (OpenAI)
- [ ] Dashboard do cliente (favoritos, histórico, alertas)
- [ ] CRM de corretores
- [ ] Tour virtual 360°
- [ ] Calculadora de financiamento

## Para rodar

```bash
npm install
cp .env.example .env.local  # preencha as variáveis
npx prisma db push
npm run dev
```
