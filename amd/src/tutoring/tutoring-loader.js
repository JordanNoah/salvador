define(['jquery', 'core/templates'], function($, Templates) {
  return {
      init: function() {
          // Handler for opening a chat from the chat menu
          $('#chat-container').on('click', '.chat-select', function() {
              var context = JSON.parse($(this).data('context')); // Make sure to get the context if passed

              Templates.render('local_digitalta/test/menu_chat/chat_detail', context)
                  .then(function(html, js) {
                      $('#chat-container').html(html);
                      Templates.runTemplateJS(js);
                      return;
                  }).fail(function(ex) {
                    //eslint-disable-next-line no-console
                      console.warn('Failed to render chat detail template:', ex);
                  });
          });

          // Handler for returning to the main chat menu
          $('#chat-container').on('click', '.btn-back', function() {
              Templates.render('local_digitalta/test/menu_chat/main', {})
                  .then(function(html, js) {
                      $('#chat-container').html(html);
                      Templates.runTemplateJS(js);
                      return;
                  }).fail(function(ex) {
                    //eslint-disable-next-line no-console
                      console.warn('Failed to render main chat template:', ex);
                  });
          });

          // Handler for opening group chats
          $('#chat-container').on('click', '.btn-chat', function() {
              var context = JSON.parse($(this).data('context'));

              Templates.render('local_digitalta/test/chat/group_chat', context)
                  .then(function(html, js) {
                      $('#chat-container').html(html);
                      Templates.runTemplateJS(js);
                      return;

                  }).fail(function(ex) {
                    //eslint-disable-next-line no-console
                      console.warn('Failed to render group chat template:', ex);
                  });
          });

          // Handler for opening tutoring requests
          $('#chat-container').on('click', '.tutoring-requests', function() {
              Templates.render('local_digitalta/test/menu_message/tutoring_requests', {})
                  .then(function(html, js) {
                      $('#chat-container').html(html);
                      Templates.runTemplateJS(js);
                      return;
                  }).fail(function(ex) {
                    //eslint-disable-next-line no-console
                      console.warn('Failed to render tutoring requests template:', ex);
                  });
          });
      }
  };
});
