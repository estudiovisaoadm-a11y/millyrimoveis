<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function haven_admin_cta_form_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $fields = haven_get_cta_lead_form_fields();
    ?>
    <div class="wrap haven-admin-wrap">
        <div class="haven-admin-header">
            <h1>Conversao e WhatsApp</h1>
            <p>Configure a frase inicial, as perguntas e as opcoes exibidas antes de abrir o WhatsApp.</p>
        </div>
        <form method="post" action="options.php">
            <?php settings_fields( 'haven_cta_form_group' ); ?>
            <div class="haven-admin-card">
                <h2>Textos do formulario</h2>
                <table class="form-table">
                    <tr><th>Titulo do modal</th><td><input type="text" name="haven_cta_form_title" value="<?php echo esc_attr( haven_opt( 'haven_cta_form_title' ) ); ?>" class="large-text"></td></tr>
                    <tr><th>Frase de apoio</th><td><textarea name="haven_cta_form_desc" rows="3" class="large-text"><?php echo esc_textarea( haven_opt( 'haven_cta_form_desc' ) ); ?></textarea></td></tr>
                    <tr><th>Mensagem enviada</th><td><textarea name="haven_cta_form_message_intro" rows="3" class="large-text"><?php echo esc_textarea( haven_opt( 'haven_cta_form_message_intro' ) ); ?></textarea><p class="description">Use {imovel} para inserir automaticamente o nome do imovel antes das respostas.</p></td></tr>
                    <tr><th>Texto do botao</th><td><input type="text" name="haven_cta_form_submit_text" value="<?php echo esc_attr( haven_opt( 'haven_cta_form_submit_text' ) ); ?>" class="regular-text"></td></tr>
                </table>
            </div>

            <div class="haven-admin-card">
                <h2>Botao flutuante</h2>
                <table class="form-table">
                    <tr>
                        <th>Ativar botao</th>
                        <td><input type="hidden" name="haven_floating_cta_enabled" value="0"><label><input type="checkbox" name="haven_floating_cta_enabled" value="1" <?php checked( haven_opt( 'haven_floating_cta_enabled' ), '1' ); ?>> Exibir botao flutuante com o mesmo formulario</label></td>
                    </tr>
                    <tr>
                        <th>Canto da tela</th>
                        <td>
                            <select name="haven_floating_cta_corner">
                                <option value="bottom-right" <?php selected( haven_opt( 'haven_floating_cta_corner' ), 'bottom-right' ); ?>>Inferior direito</option>
                                <option value="bottom-left" <?php selected( haven_opt( 'haven_floating_cta_corner' ), 'bottom-left' ); ?>>Inferior esquerdo</option>
                                <option value="top-right" <?php selected( haven_opt( 'haven_floating_cta_corner' ), 'top-right' ); ?>>Superior direito</option>
                                <option value="top-left" <?php selected( haven_opt( 'haven_floating_cta_corner' ), 'top-left' ); ?>>Superior esquerdo</option>
                            </select>
                        </td>
                    </tr>
                    <tr><th>Aparecer apos</th><td><input type="number" name="haven_floating_cta_show_delay" value="<?php echo esc_attr( haven_opt( 'haven_floating_cta_show_delay' ) ); ?>" min="0" step="1" class="small-text"> segundos</td></tr>
                    <tr><th>Pulsar apos</th><td><input type="number" name="haven_floating_cta_pulse_delay" value="<?php echo esc_attr( haven_opt( 'haven_floating_cta_pulse_delay' ) ); ?>" min="0" step="1" class="small-text"> segundos</td></tr>
                    <tr><th>Mensagem estilizada apos</th><td><input type="number" name="haven_floating_cta_message_delay" value="<?php echo esc_attr( haven_opt( 'haven_floating_cta_message_delay' ) ); ?>" min="0" step="1" class="small-text"> segundos</td></tr>
                    <tr><th>Mensagem apos badge</th><td><input type="number" name="haven_floating_cta_badge_message_delay" value="<?php echo esc_attr( haven_opt( 'haven_floating_cta_badge_message_delay' ) ); ?>" min="0" step="1" class="small-text"> segundos<p class="description">Esse tempo passa a contar somente depois que o badge vermelho aparecer.</p></td></tr>
                    <tr>
                        <th>Secao para badge</th>
                        <td>
                            <select name="haven_floating_cta_badge_section">
                                <option value="">Nao usar badge por secao</option>
                                <?php foreach ( haven_get_menu_section_targets() as $section_value => $section_label ) : ?>
                                    <option value="<?php echo esc_attr( ltrim( $section_value, '#' ) ); ?>" <?php selected( haven_opt( 'haven_floating_cta_badge_section' ), ltrim( $section_value, '#' ) ); ?>><?php echo esc_html( $section_label ); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr><th>Numero do badge</th><td><input type="number" name="haven_floating_cta_badge_text" value="<?php echo esc_attr( haven_opt( 'haven_floating_cta_badge_text' ) ); ?>" min="1" step="1" class="small-text"><p class="description">Exibe a bolinha vermelha com este numero de nova mensagem.</p></td></tr>
                    <tr><th>Mensagem estilizada</th><td><textarea name="haven_floating_cta_message_text" rows="3" class="large-text"><?php echo esc_textarea( haven_opt( 'haven_floating_cta_message_text' ) ); ?></textarea></td></tr>
                </table>
            </div>

            <div class="haven-admin-card haven-admin-card-span-2">
                <h2>Perguntas e opcoes</h2>
                <p class="description">Edite as perguntas padrao, adicione novas e inclua quantas opcoes precisar em cada uma.</p>
                <div class="haven-cta-fields-list" id="haven-cta-fields-list">
                    <?php foreach ( $fields as $field_index => $field ) : ?>
                        <div class="haven-cta-field-card" data-index="<?php echo esc_attr( $field_index ); ?>">
                            <div class="haven-cta-field-head">
                                <strong>Pergunta</strong>
                                <button type="button" class="button-link-delete haven-remove-cta-field">Remover</button>
                            </div>
                            <div class="haven-cta-field-grid">
                                <label>
                                    <span>Rotulo</span>
                                    <input type="text" name="haven_cta_form_fields[<?php echo esc_attr( $field_index ); ?>][label]" value="<?php echo esc_attr( $field['label'] ?? '' ); ?>" class="large-text">
                                </label>
                                <label>
                                    <span>Placeholder</span>
                                    <input type="text" name="haven_cta_form_fields[<?php echo esc_attr( $field_index ); ?>][placeholder]" value="<?php echo esc_attr( $field['placeholder'] ?? '' ); ?>" class="regular-text">
                                </label>
                            </div>
                            <div class="haven-cta-field-toggles">
                                <label><input type="hidden" name="haven_cta_form_fields[<?php echo esc_attr( $field_index ); ?>][enabled]" value="0"><input type="checkbox" name="haven_cta_form_fields[<?php echo esc_attr( $field_index ); ?>][enabled]" value="1" <?php checked( $field['enabled'] ?? '1', '1' ); ?>> Exibir campo</label>
                                <label><input type="hidden" name="haven_cta_form_fields[<?php echo esc_attr( $field_index ); ?>][required]" value="0"><input type="checkbox" name="haven_cta_form_fields[<?php echo esc_attr( $field_index ); ?>][required]" value="1" <?php checked( $field['required'] ?? '0', '1' ); ?>> Obrigatorio</label>
                            </div>
                            <div class="haven-cta-options-list">
                                <?php foreach ( $field['options'] as $option_index => $option ) : ?>
                                    <div class="haven-cta-option-row" data-option-index="<?php echo esc_attr( $option_index ); ?>">
                                        <input type="text" name="haven_cta_form_fields[<?php echo esc_attr( $field_index ); ?>][options][<?php echo esc_attr( $option_index ); ?>][label]" value="<?php echo esc_attr( $option['label'] ?? '' ); ?>" class="regular-text" placeholder="Opcao">
                                        <button type="button" class="button-link-delete haven-remove-cta-option">Remover opcao</button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="button haven-add-cta-option">Adicionar opcao</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <p><button type="button" class="button button-secondary" id="haven-add-cta-field">Adicionar pergunta</button></p>
            </div>
            <?php submit_button( 'Salvar formulario WhatsApp' ); ?>
        </form>
    </div>
    <script type="text/html" id="haven-cta-field-template">
        <div class="haven-cta-field-card" data-index="__INDEX__">
            <div class="haven-cta-field-head">
                <strong>Pergunta</strong>
                <button type="button" class="button-link-delete haven-remove-cta-field">Remover</button>
            </div>
            <div class="haven-cta-field-grid">
                <label>
                    <span>Rotulo</span>
                    <input type="text" name="haven_cta_form_fields[__INDEX__][label]" value="" class="large-text">
                </label>
                <label>
                    <span>Placeholder</span>
                    <input type="text" name="haven_cta_form_fields[__INDEX__][placeholder]" value="Selecione uma opcao" class="regular-text">
                </label>
            </div>
            <div class="haven-cta-field-toggles">
                <label><input type="hidden" name="haven_cta_form_fields[__INDEX__][enabled]" value="0"><input type="checkbox" name="haven_cta_form_fields[__INDEX__][enabled]" value="1" checked> Exibir campo</label>
                <label><input type="hidden" name="haven_cta_form_fields[__INDEX__][required]" value="0"><input type="checkbox" name="haven_cta_form_fields[__INDEX__][required]" value="1"> Obrigatorio</label>
            </div>
            <div class="haven-cta-options-list">
                <div class="haven-cta-option-row" data-option-index="0">
                    <input type="text" name="haven_cta_form_fields[__INDEX__][options][0][label]" value="" class="regular-text" placeholder="Opcao">
                    <button type="button" class="button-link-delete haven-remove-cta-option">Remover opcao</button>
                </div>
            </div>
            <button type="button" class="button haven-add-cta-option">Adicionar opcao</button>
        </div>
    </script>
    <style>
        .haven-cta-field-card{border:1px solid #e5e0d8;border-radius:16px;padding:18px;margin-bottom:16px;background:#fff7ec}
        .haven-cta-field-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
        .haven-cta-field-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:12px}
        .haven-cta-field-grid label,.haven-cta-field-toggles label{display:flex;flex-direction:column;gap:6px}
        .haven-cta-field-toggles{display:flex;gap:24px;flex-wrap:wrap;margin-bottom:12px}
        .haven-cta-options-list{display:flex;flex-direction:column;gap:10px;margin-bottom:12px}
        .haven-cta-option-row{display:flex;gap:10px;align-items:center}
        .haven-cta-option-row input{flex:1}
        @media (max-width: 782px){.haven-cta-field-grid{grid-template-columns:1fr}.haven-cta-option-row{flex-direction:column;align-items:stretch}}
    </style>
    <?php
}

