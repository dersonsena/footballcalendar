var ModalAlerts = (function($, Utils) {

    var $modalAlert = {};

    var $modalConfirm = {
        title : null,
        message : null,
        negativeButton : null,
        positiveButton : null,
        positiveButtonText : 'OK',
        negativeButtonText : 'Cancelar'
    };

    function alert(title, message, callback) {

        var applyEvents = ($('#modal-alerts-confirm').size() === 0);

        addHTMLModalAlertInBody();

        title = (!title || title == '' || title == null || title == undefined ? 'Aplicação diz:' : title);

        $modalAlert.title.html(title);
        $modalAlert.message.html(message);

        $modalAlert.target.modal({
            backdrop : 'static',
            keyboard : false
        });

        $modalAlert.target.on('shown.bs.modal', function() {
            $modalAlert.target.find('div.modal-footer button').focus();
        });

        if (callback) {

            if (!applyEvents)
                return;

            $modalAlert.target.on('hide.bs.modal', callback);
        }

    };

    function confirm(title, message, positiveCallback, negativeCallback) {

        var applyEvents = ($('#modal-alerts-confirm').size() === 0);

        addHTMLModalConfirmInBody();

        title = (!title || title == '' || title == null || title == undefined ? 'Aplicação diz:' : title);

        $modalConfirm.title.html(title);
        $modalConfirm.message.html(message);
        $modalConfirm.positiveButton = $modalConfirm.target.find('button.btn-success');
        $modalConfirm.negativeButton = $modalConfirm.target.find('button.btn-success');

        $modalConfirm.target.modal({
            backdrop : 'static',
            keyboard : false
        });

        if (!applyEvents)
            return;

        $modalConfirm.positiveButton.off('click', positiveCallback);
        $modalConfirm.positiveButton.on('click', positiveCallback);

        if (negativeCallback) {
            $modalConfirm.negativeButton.off('click', negativeCallback);
            $modalConfirm.negativeButton.on('click', negativeCallback);
        }
    };

    /**
     * Metodo que retorna o HTML com a estrutura no modal do alert para ser adicionado na pagina
     * @returns {string}
     */
    function getHTMLModalAlert() {

        return '<div class="modal fade" id="modal-alerts-alert" tabindex="-1" role="dialog">'+
               '    <div class="modal-dialog">'+
               '         <div class="modal-content">'+
               '             <div class="modal-header">'+
               '                 <h4 class="modal-title modal-alerts-alert-title">'+
               '                     <i class="glyphicon glyphicon-info-sign"></i> <span></span>'+
               '                 </h4>'+
               '             </div>'+
               '             <div class="modal-body">'+
               '                 <p class="modal-alerts-alert-message">Mensagem do Alert</p>'+
               '             </div>'+
               '             <div class="modal-footer">'+
               '                 <button type="button" class="btn btn-danger" data-dismiss="modal">'+
               '                     <i class="glyphicon glyphicon-remove"></i> Fechar'+
               '                 </button>'+
               '             </div>'+
               '        </div>'+
               '    </div>'+
               '</div>';
    };

    /**
     * Metodo que retorna o HTML com a estrutura no modal do confirm para ser adicionado na pagina
     * @returns {string}
     */
    function getHTMLModalConfirm() {

        return '<div class="modal fade bg-black opacity-80" id="modal-alerts-confirm" style="z-index: 9999" tabindex="-1" role="dialog">'+
               '    <div class="modal-dialog">'+
               '        <div class="modal-content">'+
               '            <div class="modal-header">'+
               '                <h4 class="modal-title modal-alerts-confirm-title">'+
               '                    <i class="glyphicon glyphicon-question-sign"></i> <span></span>'+
               '                </h4>'+
               '            </div>'+
               '            <div class="modal-body">'+
               '                <p class="modal-alerts-confirm-message">Mensagem do Alert</p>'+
               '            </div>'+
               '            <div class="modal-footer">'+
               '                <button type="button" class="btn btn-danger" data-dismiss="modal">'+
               '                    <i class="glyphicon glyphicon-remove-sign"></i> '+ $modalConfirm.negativeButtonText +
               '                </button>'+
               '                <button type="button" class="btn btn-success" data-dismiss="modal">'+
               '                    <i class="glyphicon glyphicon-ok-sign"></i> '+ $modalConfirm.positiveButtonText +
               '                </button>'+
               '            </div>'+
               '        </div>'+
               '    </div>'+
               '</div>';
    };

    /**
     * Metodo que adiciona o template HTML do modal do alert dentro da tag BODY e inicializa
     * as respectivas variaveis
     * @return void
     */
    function addHTMLModalAlertInBody() {

        if($('#modal-alerts-alert').size() > 0)
            return;

        $('body').prepend(getHTMLModalAlert());

        $modalAlert = {
            target : $('#modal-alerts-alert'),
            title : $('.modal-alerts-alert-title > span'),
            message : $('.modal-alerts-alert-message')
        };

    };

    /**
     * Metodo que adiciona o template HTML do modal do confirm dentro da tag BODY e inicializa
     * as respectivas variaveis
     * @return void
     */
    function addHTMLModalConfirmInBody() {

        if ($('#modal-alerts-confirm').size() > 0)
            return;

        $('body').prepend(getHTMLModalConfirm());

        $modalConfirm = {
            target : $('#modal-alerts-confirm'),
            title : $('.modal-alerts-confirm-title > span'),
            message : $('.modal-alerts-confirm-message')
        };

    };

    /**
     * Metodo que seta o texto para o botao positivo do confirm
     * @param text
     * @return void
     */
    function setPositiveButtonTextConfirm(text) {
        $modalConfirm.positiveButtonText = text;
    };

    /**
     * Metodo que seta o texto para o botao negativo do confirm
     * @param text
     * @return void
     */
    function setNegativeButtonTextConfirm(text) {
        $modalConfirm.negativeButtonText = text;
    };

    function getConfirmPositiveButton() {
        return $modalConfirm.positiveButton;
    };

    function getConfirmNegativeButton() {
        return $modalConfirm.negativeButton;
    };

    return {
        alert : alert,
        confirm : confirm,
        setPositiveButtonTextConfirm : setPositiveButtonTextConfirm,
        setNegativeButtonTextConfirm : setNegativeButtonTextConfirm,
        getConfirmPositiveButton : getConfirmPositiveButton,
        getConfirmNegativeButton : getConfirmNegativeButton,
    }

})(jQuery, Utils);