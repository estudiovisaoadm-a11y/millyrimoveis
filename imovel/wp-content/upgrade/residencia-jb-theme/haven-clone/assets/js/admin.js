/**
 * HAVEN ADMIN — Media Upload & Photo Management JS
 */
(function($) {
  'use strict';

  // ---- Upload single image (video background) ----
  $(document).on('click', '.haven-upload-single', function(e) {
    e.preventDefault();
    var fieldId = $(this).data('field');
    var btn = $(this);

    var frame = wp.media({
      title: 'Selecionar Imagem',
      button: { text: 'Usar esta imagem' },
      multiple: false
    });

    frame.on('select', function() {
      var attachment = frame.state().get('selection').first().toJSON();
      $('#' + fieldId).val(attachment.url);
      // Update preview
      var container = btn.closest('.haven-single-photo');
      container.find('img').remove();
      container.prepend('<img src="'+attachment.url+'" style="max-width:400px;border-radius:8px;">');
    });

    frame.open();
  });

  // ---- Add Hero Photo ----
  $(document).on('click', '.haven-add-photo[data-target="hero"]', function(e) {
    e.preventDefault();
    var frame = wp.media({
      title: 'Adicionar Foto ao Hero',
      button: { text: 'Adicionar' },
      multiple: true
    });

    frame.on('select', function() {
      var attachments = frame.state().get('selection').toJSON();
      var grid = $('#haven-hero-photos');
      attachments.forEach(function(att) {
        var idx = grid.find('.haven-photo-item').length;
        var html = '<div class="haven-photo-item" data-index="'+idx+'">';
        html += '<img src="'+att.url+'" alt="Hero '+(idx+1)+'">';
        html += '<div class="haven-photo-actions">';
        html += '<button type="button" class="button haven-change-photo" data-target="hero" data-index="'+idx+'">Trocar</button>';
        html += '<button type="button" class="button haven-remove-photo" data-target="hero" data-index="'+idx+'">✕</button>';
        html += '</div>';
        html += '<input type="hidden" name="haven_hero_photos[]" value="'+att.url+'">';
        html += '</div>';
        grid.append(html);
      });
    });

    frame.open();
  });

  // ---- Add Gallery Photo ----
  $(document).on('click', '.haven-add-gallery-photo', function(e) {
    e.preventDefault();
    var frame = wp.media({
      title: 'Adicionar Ambiente à Galeria',
      button: { text: 'Adicionar' },
      multiple: true
    });

    frame.on('select', function() {
      var attachments = frame.state().get('selection').toJSON();
      var grid = $('#haven-gallery-photos');
      attachments.forEach(function(att) {
        var idx = grid.find('.haven-photo-item').length;
        var html = '<div class="haven-photo-item" data-index="'+idx+'">';
        html += '<img src="'+att.url+'" alt="Ambiente '+(idx+1)+'">';
        html += '<div class="haven-photo-fields">';
        html += '<input type="text" name="haven_gallery_photos['+idx+'][title]" value="" placeholder="Nome do ambiente">';
        html += '<input type="text" name="haven_gallery_photos['+idx+'][badge]" value="" placeholder="Badge (ex: Destaque)">';
        html += '<input type="text" name="haven_gallery_photos['+idx+'][desc]" value="" placeholder="Descrição curta">';
        html += '<input type="text" name="haven_gallery_photos['+idx+'][feat1]" value="" placeholder="Feature 1 (ex: 📐 85m²)">';
        html += '<input type="text" name="haven_gallery_photos['+idx+'][feat2]" value="" placeholder="Feature 2">';
        html += '<input type="text" name="haven_gallery_photos['+idx+'][feat3]" value="" placeholder="Feature 3">';
        html += '</div>';
        html += '<div class="haven-photo-actions">';
        html += '<button type="button" class="button haven-change-photo" data-target="gallery" data-index="'+idx+'">Trocar Foto</button>';
        html += '<button type="button" class="button haven-remove-photo" data-target="gallery" data-index="'+idx+'">✕</button>';
        html += '</div>';
        html += '<input type="hidden" name="haven_gallery_photos['+idx+'][url]" value="'+att.url+'">';
        html += '</div>';
        grid.append(html);
      });
    });

    frame.open();
  });

  // ---- Change Photo ----
  $(document).on('click', '.haven-change-photo', function(e) {
    e.preventDefault();
    var item = $(this).closest('.haven-photo-item');

    var frame = wp.media({
      title: 'Trocar Foto',
      button: { text: 'Usar esta foto' },
      multiple: false
    });

    frame.on('select', function() {
      var attachment = frame.state().get('selection').first().toJSON();
      item.find('img').attr('src', attachment.url);
      // Update hidden input
      var target = $(e.target).data('target');
      if (target === 'hero') {
        item.find('input[type="hidden"]').val(attachment.url);
      } else {
        item.find('input[name$="[url]"]').val(attachment.url);
      }
    });

    frame.open();
  });

  // ---- Remove Photo ----
  $(document).on('click', '.haven-remove-photo', function(e) {
    e.preventDefault();
    if (confirm('Remover esta foto?')) {
      $(this).closest('.haven-photo-item').fadeOut(300, function() {
        $(this).remove();
      });
    }
  });

})(jQuery);
