<?php
/* Template Name: MillyR - Contato */
get_header(); ?>
<section class="page-banner">
    <div class="container">
        <h1>Fale <span class="text-gold">Conosco</span></h1>
        <p>Estamos prontos para atender você. Entre em contato conosco.</p>
    </div>
</section>
<section class="section page-content">
    <div class="container">
        <div class="contact-grid">
            <div>
                <h2 style="margin-top:0;">Envie sua <span class="text-gold">Mensagem</span></h2>
                <p style="margin-bottom:32px;">Preencha o formulário abaixo e nossa equipe entrará em contato em até 24 horas.</p>
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="millyr_contact">
                    <div class="form-group">
                        <label>Nome completo</label>
                        <input type="text" name="nome" required placeholder="Seu nome">
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" name="email" required placeholder="seu@email.com">
                    </div>
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="tel" name="telefone" placeholder="(61) 99999-9999">
                    </div>
                    <div class="form-group">
                        <label>Assunto</label>
                        <select name="assunto">
                            <option value="comprar">Quero comprar</option>
                            <option value="alugar">Quero alugar</option>
                            <option value="vender">Quero vender</option>
                            <option value="avaliacao">Avaliação de imóvel</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mensagem</label>
                        <textarea name="mensagem" required placeholder="Conte-nos como podemos ajudar..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Mensagem</button>
                </form>
            </div>
            <div>
                <h2 style="margin-top:0;">Nossas <span class="text-gold">Informações</span></h2>
                <div class="contact-info-card">
                    <h3>📍 Endereço</h3>
                    <p>SHIS QI 9, Bloco A, Loja 101<br>Lago Sul, Brasília - DF<br>CEP: 71625-200</p>
                </div>
                <div class="contact-info-card">
                    <h3>📞 Telefone</h3>
                    <p><a href="tel:+5561999999999">(61) 99999-9999</a></p>
                </div>
                <div class="contact-info-card">
                    <h3>✉️ E-mail</h3>
                    <p><a href="mailto:contato@millyrimoveis.com.br">contato@millyrimoveis.com.br</a></p>
                </div>
                <div class="contact-info-card">
                    <h3>🕐 Horário</h3>
                    <p>Seg a Sex: 8h às 18h<br>Sáb: 8h às 13h</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>
