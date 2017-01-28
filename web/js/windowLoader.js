var WindowLoader = (function($) {

    var $modal;
    var $title;
    var $message;
    var $progress;

    /**
     * Metodo que retorna o HTML com a estrutura no modal para ser adicionado na pagina
     * @returns {string}
     */
    function getHTMLModal() {

        return '<div class="modal fade" id="window-loader-modal" tabindex="-1" role="dialog">'+
               '           <div class="modal-dialog">'+
               '               <div class="modal-content">'+
               '                   <div class="modal-header">'+
               '                       <h4 class="modal-title window-loader-title"></h4>'+
               '                   </div>'+
               '                  <div class="modal-body">'+
               '                      <div class="progress">'+
               '                          <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>'+
               '                      </div>'+
               '                      <p class="text-center window-loader-message"></p>'+
               '                  </div>'+
               '               </div>'+
               '           </div>'+
               '</div>';
    };

    /**
     * Metodo que abre o modal
     * @param options
     */
    function show(options) {

        addHTMLModalInBody();

        var title = (options && options.hasOwnProperty('title') ? options.title : 'Carregando, por favor, aguarde...');
        var message = (options && options.hasOwnProperty('message') ? options.message : '');
        var progressClass = (options && options.hasOwnProperty('progressClass') ? options.progressClass : 'progress-bar-striped');

        $title.html(title);
        $progress.addClass(progressClass);

        if(message === '')
            $message.hide();
        else
            $message.html(message).show();

        $modal.modal({
            backdrop : 'static',
            keyboard : false
        });

    };

    /**
     * Metodo que esconde o modal e limpa o conteudo do title e message
     * @return void
     */
    function hide() {
        $modal.modal('hide');
        $title.html('');
        $message.html('');
    };

    /**
     * Metodo que adiciona o template HTML do modal dentro da tag BODY e inicializa
     * as respectivas variaveis
     * @return void
     */
    function addHTMLModalInBody() {

        if($('#window-loader-modal').size() > 0)
            return;

        $('body').prepend(getHTMLModal());
        $modal = $('#window-loader-modal');
        $title = $('.window-loader-title');
        $message = $('.window-loader-message');
        $progress = $modal.find('.progress-bar');

    };

    return {
        show : show,
        hide : hide
    }

})(jQuery);