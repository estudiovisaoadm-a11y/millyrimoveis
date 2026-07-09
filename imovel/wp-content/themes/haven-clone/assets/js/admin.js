/**
 * HAVEN ADMIN - Media Upload & Photo Management JS
 */
(function($) {
  'use strict';

  const galleryTargets = {
    gallery: {
      grid: '#haven-gallery-photos',
      option: 'haven_gallery_photos',
      imageAlt: 'Ambiente',
      fields(item, idx) {
        return [
          '<input type="text" name="haven_gallery_photos[' + idx + '][title]" value="' + escapeHtml(item.title || '') + '" placeholder="Nome do ambiente">',
          '<input type="text" name="haven_gallery_photos[' + idx + '][badge]" value="' + escapeHtml(item.badge || '') + '" placeholder="Badge (ex: Destaque)">',
          '<textarea name="haven_gallery_photos[' + idx + '][desc]" rows="3" placeholder="Descricao curta do ambiente">' + escapeHtml(item.desc || '') + '</textarea>',
          '<input type="text" name="haven_gallery_photos[' + idx + '][feat1]" value="' + escapeHtml(item.feat1 || '') + '" placeholder="Feature 1">',
          '<input type="text" name="haven_gallery_photos[' + idx + '][feat2]" value="' + escapeHtml(item.feat2 || '') + '" placeholder="Feature 2">',
          '<input type="text" name="haven_gallery_photos[' + idx + '][feat3]" value="' + escapeHtml(item.feat3 || '') + '" placeholder="Feature 3">'
        ].join('');
      }
    },
    details: {
      grid: '#haven-details-gallery-photos',
      option: 'haven_details_gallery_photos',
      imageAlt: 'Detalhe',
      fields(item, idx) {
        return [
          '<input type="text" name="haven_details_gallery_photos[' + idx + '][title]" value="' + escapeHtml(item.title || '') + '" placeholder="Titulo opcional">',
          '<textarea name="haven_details_gallery_photos[' + idx + '][desc]" rows="2" placeholder="Legenda opcional">' + escapeHtml(item.desc || '') + '</textarea>'
        ].join('');
      }
    }
  };

  function escapeHtml(value) {
    return String(value || '')
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function buildGalleryCard(target, item, idx) {
    const config = galleryTargets[target];
    return [
      '<div class="haven-photo-item haven-photo-item-' + target + '" data-index="' + idx + '">',
      '<img src="' + escapeHtml(item.url || '') + '" alt="' + escapeHtml(item.title || config.imageAlt) + '">',
      '<div class="haven-photo-fields">',
      config.fields(item, idx),
      '</div>',
      '<div class="haven-photo-actions">',
      '<button type="button" class="button haven-change-photo" data-target="' + target + '" data-index="' + idx + '">Trocar</button>',
      '<button type="button" class="button haven-remove-photo" data-target="' + target + '" data-index="' + idx + '">x</button>',
      '</div>',
      '<input type="hidden" name="' + config.option + '[' + idx + '][url]" value="' + escapeHtml(item.url || '') + '">',
      '</div>'
    ].join('');
  }

  function buildHeroCard(url, idx) {
    return [
      '<div class="haven-photo-item" data-index="' + idx + '">',
      '<img src="' + escapeHtml(url) + '" alt="Hero ' + (idx + 1) + '">',
      '<div class="haven-photo-actions">',
      '<button type="button" class="button haven-change-photo" data-target="hero" data-index="' + idx + '">Trocar</button>',
      '<button type="button" class="button haven-remove-photo" data-target="hero" data-index="' + idx + '">x</button>',
      '</div>',
      '<input type="hidden" name="haven_hero_photos[]" value="' + escapeHtml(url) + '">',
      '</div>'
    ].join('');
  }

  function getGrid(target) {
    if (target === 'hero') {
      return $('#haven-hero-photos');
    }

    return $(galleryTargets[target].grid);
  }

  function reindexGrid(target) {
    const $grid = getGrid(target);
    if (!$grid.length) return;

    $grid.find('.haven-photo-item').each(function(index) {
      const $item = $(this);
      $item.attr('data-index', index);
      $item.find('.haven-change-photo, .haven-remove-photo').attr('data-index', index);

      if (target === 'hero') {
        $item.find('img').attr('alt', 'Hero ' + (index + 1));
        return;
      }

      const option = galleryTargets[target].option;
      $item.find('input, textarea').each(function() {
        const $field = $(this);
        const name = $field.attr('name');
        if (!name) return;
        $field.attr('name', name.replace(new RegExp(option + '\\\\[\\d+\\\\]'), option + '[' + index + ']'));
      });
    });
  }

  function openMediaFrame(options, onSelect) {
    const frame = wp.media({
      title: options.title,
      button: { text: options.buttonText },
      multiple: !!options.multiple
    });

    frame.on('select', function() {
      const selection = frame.state().get('selection').toJSON();
      onSelect(selection);
    });

    frame.open();
  }

  function ensureSinglePhotoPreview($container, url) {
    let $img = $container.find('img');
    if (!$img.length) {
      $img = $('<img>', { alt: 'Preview da imagem' });
      $container.prepend($img);
    }

    $img.attr('src', url);

    if (!$container.find('.haven-remove-single').length) {
      const fieldId = $container.find('input[type="hidden"]').attr('id');
      if (fieldId) {
        $container.append('<button type="button" class="button haven-remove-single" data-field="' + escapeHtml(fieldId) + '">Remover</button>');
      }
    }
  }

  $(function() {
    if ($.fn.wpColorPicker) {
      $('.haven-color-field').wpColorPicker();
    }

    $('.haven-live-range').each(function() {
      updateLiveRange(this);
    });
  });

  function updateLiveRange(input) {
    const valueTarget = input.dataset.valueTarget ? document.getElementById(input.dataset.valueTarget) : null;
    const suffix = input.dataset.previewSuffix || 'px';
    if (valueTarget) {
      valueTarget.textContent = input.value + suffix;
    }

    if (input.dataset.previewTarget && input.dataset.previewProp) {
      const preview = document.getElementById(input.dataset.previewTarget);
      if (preview) {
        preview.style[input.dataset.previewProp] = input.value + suffix;
      }
    }
  }

  $(document).on('input change', '.haven-live-range', function() {
    updateLiveRange(this);
  });

  function updatePreloaderPreviewProp(input) {
    const preview = document.getElementById(input.dataset.previewTarget || '');
    if (!preview) return;

    if (input.dataset.previewProp === 'backgroundColor') {
      preview.style.backgroundColor = input.value;
    }

    if (input.dataset.previewProp === 'accentColor') {
      preview.style.setProperty('--haven-preloader-preview-accent', input.value);
    }
  }

  $(document).on('change input', '.haven-preloader-live', function() {
    updatePreloaderPreviewProp(this);
  });

  function updateTestimonialPreviewField(input) {
    const targetName = input.dataset.testimonialPreviewTarget;
    if (!targetName) return;

    const previewNodes = document.querySelectorAll('[data-testimonial-preview="' + targetName + '"]');
    if (!previewNodes.length) return;

    let value = input.value || '';
    if (targetName.indexOf('avatar-') === 0) {
      value = value.toUpperCase().slice(0, 2);
      input.value = value;
    }

    previewNodes.forEach(function(node) {
      if (targetName.indexOf('quote-') === 0) {
        node.textContent = value ? '"' + value + '"' : '""';
        return;
      }

      node.textContent = value;
    });
  }

  $(function() {
    document.querySelectorAll('[data-testimonial-preview-target]').forEach(function(input) {
      updateTestimonialPreviewField(input);
    });
  });

  $(document).on('input change', '[data-testimonial-preview-target]', function() {
    updateTestimonialPreviewField(this);
  });

  $(document).on('change', '.haven-preloader-select', function() {
    const preview = document.getElementById(this.dataset.previewClassTarget || '');
    const prefix = this.dataset.previewClassPrefix || '';
    if (!preview || !prefix) return;

    preview.className = preview.className
      .split(' ')
      .filter(cls => cls.indexOf(prefix) !== 0)
      .join(' ');

    preview.classList.add(prefix + this.value);
  });

  function syncMenuItemFields($item) {
    const type = $item.find('.haven-menu-type').val() || 'section';
    $item.find('.haven-menu-value-section, .haven-menu-value-page, .haven-menu-value-url, .haven-menu-value-email, .haven-menu-value-phone')
      .addClass('is-hidden')
      .find('input, select, textarea')
      .prop('disabled', true);

    $item.find('.haven-menu-value-' + type)
      .removeClass('is-hidden')
      .find('input, select, textarea')
      .prop('disabled', false);
  }

  function reindexMenuList($list) {
    const location = $list.data('location');
    $list.find('.haven-menu-item').each(function(index) {
      const $item = $(this);
      $item.attr('data-index', index);
      $item.find('input, select, textarea').each(function() {
        const $field = $(this);
        const name = $field.attr('name');
        if (!name) return;
        $field.attr('name', name.replace(new RegExp('haven_visual_menus\\[' + location + '\\]\\[\\d+\\]'), 'haven_visual_menus[' + location + '][' + index + ']'));
      });
    });
  }

  function initVisualMenuEditor() {
    $('.haven-visual-menu-list').each(function() {
      const $list = $(this);
      if ($list.data('ui-sortable')) return;
      if ($.fn.sortable) {
        $list.sortable({
          handle: '.haven-menu-item-handle',
          update: function() {
            reindexMenuList($list);
          }
        });
      }
    });

    $('.haven-menu-item').each(function() {
      syncMenuItemFields($(this));
    });
  }

  $(function() {
    initVisualMenuEditor();
  });

  $(document).on('change', '.haven-menu-type', function() {
    syncMenuItemFields($(this).closest('.haven-menu-item'));
  });

  $(document).on('click', '.haven-add-menu-item', function(e) {
    e.preventDefault();
    const location = $(this).data('location');
    const $list = $('.haven-visual-menu-list[data-location="' + location + '"]');
    const index = $list.find('.haven-menu-item').length;
    const template = $('#haven-menu-item-template').html()
      .replace(/__LOCATION__/g, location)
      .replace(/__INDEX__/g, index);
    const $item = $(template);
    $list.append($item);
    syncMenuItemFields($item);
    reindexMenuList($list);
  });

  $(document).on('click', '.haven-remove-menu-item', function(e) {
    e.preventDefault();
    const $list = $(this).closest('.haven-visual-menu-list');
    $(this).closest('.haven-menu-item').remove();
    reindexMenuList($list);
  });

  $(document).on('click', '.haven-upload-single', function(e) {
    e.preventDefault();
    const fieldId = $(this).data('field');
    const $button = $(this);

    openMediaFrame(
      {
        title: 'Selecionar imagem',
        buttonText: 'Usar esta imagem',
        multiple: false
      },
      function(selection) {
        const attachment = selection[0];
        if (!attachment) return;

        $('#' + fieldId).val(attachment.url);
        const $container = $button.closest('.haven-single-photo');
        ensureSinglePhotoPreview($container, attachment.url);

        if (fieldId === 'haven_login_bg_image') {
          $('.haven-login-preview-frame').css('background-image', 'url("' + attachment.url + '")');
        }
      }
    );
  });

  $(document).on('click', '.haven-remove-single', function(e) {
    e.preventDefault();
    const fieldId = $(this).data('field');
    $('#' + fieldId).val('');
    const $container = $(this).closest('.haven-single-photo');
    $container.find('img').remove();
    $(this).remove();
  });

  $(document).on('click', '.haven-add-photo[data-target="hero"]', function(e) {
    e.preventDefault();

    openMediaFrame(
      {
        title: 'Adicionar foto ao hero',
        buttonText: 'Adicionar',
        multiple: true
      },
      function(selection) {
        const $grid = $('#haven-hero-photos');
        selection.forEach(function(attachment) {
          const idx = $grid.find('.haven-photo-item').length;
          $grid.append(buildHeroCard(attachment.url, idx));
        });
      }
    );
  });

  $(document).on('click', '.haven-add-gallery-photo', function(e) {
    e.preventDefault();
    const target = $(this).data('target') || 'gallery';

    openMediaFrame(
      {
        title: target === 'details' ? 'Adicionar foto de detalhe' : 'Adicionar ambiente a galeria',
        buttonText: 'Adicionar',
        multiple: true
      },
      function(selection) {
        const $grid = getGrid(target);
        selection.forEach(function(attachment) {
          const idx = $grid.find('.haven-photo-item').length;
          $grid.append(buildGalleryCard(target, { url: attachment.url }, idx));
        });
      }
    );
  });

  $(document).on('click', '.haven-change-photo', function(e) {
    e.preventDefault();
    const $button = $(this);
    const target = $button.data('target');
    const $item = $button.closest('.haven-photo-item');

    openMediaFrame(
      {
        title: 'Trocar foto',
        buttonText: 'Usar esta foto',
        multiple: false
      },
      function(selection) {
        const attachment = selection[0];
        if (!attachment) return;

        $item.find('img').attr('src', attachment.url);

        if (target === 'hero') {
          $item.find('input[type="hidden"]').val(attachment.url);
        } else {
          $item.find('input[type="hidden"][name$="[url]"]').val(attachment.url);
        }
      }
    );
  });

  $(document).on('click', '.haven-remove-photo', function(e) {
    e.preventDefault();
    const target = $(this).data('target');

    if (!window.confirm('Remover esta foto?')) return;

    $(this).closest('.haven-photo-item').fadeOut(200, function() {
      $(this).remove();
      reindexGrid(target);
    });
  });

  function reindexCtaFields() {
    $('#haven-cta-fields-list .haven-cta-field-card').each(function(fieldIndex) {
      const $field = $(this);
      $field.attr('data-index', fieldIndex);
      $field.find('input, select, textarea').each(function() {
        const $input = $(this);
        const name = $input.attr('name');
        if (!name) return;
        $input.attr('name', name.replace(/haven_cta_form_fields\[\d+\]/, 'haven_cta_form_fields[' + fieldIndex + ']'));
      });

      $field.find('.haven-cta-option-row').each(function(optionIndex) {
        const $option = $(this);
        $option.attr('data-option-index', optionIndex);
        $option.find('input').each(function() {
          const $input = $(this);
          const name = $input.attr('name');
          if (!name) return;
          $input.attr('name', name.replace(/\[options\]\[\d+\]/, '[options][' + optionIndex + ']'));
        });
      });
    });
  }

  $(document).on('click', '#haven-add-cta-field', function(e) {
    e.preventDefault();
    const $list = $('#haven-cta-fields-list');
    const index = $list.find('.haven-cta-field-card').length;
    const template = ($('#haven-cta-field-template').html() || '').replace(/__INDEX__/g, index);
    $list.append(template);
    reindexCtaFields();
  });

  $(document).on('click', '.haven-remove-cta-field', function(e) {
    e.preventDefault();
    $(this).closest('.haven-cta-field-card').remove();
    reindexCtaFields();
  });

  $(document).on('click', '.haven-add-cta-option', function(e) {
    e.preventDefault();
    const $field = $(this).closest('.haven-cta-field-card');
    const fieldIndex = $field.data('index');
    const $list = $field.find('.haven-cta-options-list');
    const optionIndex = $list.find('.haven-cta-option-row').length;
    $list.append(
      '<div class="haven-cta-option-row" data-option-index="' + optionIndex + '">' +
        '<input type="text" name="haven_cta_form_fields[' + fieldIndex + '][options][' + optionIndex + '][label]" value="" class="regular-text" placeholder="Opcao">' +
        '<button type="button" class="button-link-delete haven-remove-cta-option">Remover opcao</button>' +
      '</div>'
    );
    reindexCtaFields();
  });

  $(document).on('click', '.haven-remove-cta-option', function(e) {
    e.preventDefault();
    const $field = $(this).closest('.haven-cta-field-card');
    $(this).closest('.haven-cta-option-row').remove();
    reindexCtaFields();
    if (!$field.find('.haven-cta-option-row').length) {
      $field.find('.haven-add-cta-option').trigger('click');
    }
  });
})(jQuery);
