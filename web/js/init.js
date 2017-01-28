var Init = (function($) {

    var $logoutLink = $('a.btn-system-logout');

    var moneyMaskOptions = {
        //prefix : 'R$ ',
        suffix : '',
        affixesStay : true,
        thousands : '.',
        decimal : ',',
        precision : 2,
        allowZero : true,
        allowNegative : false
    };

    $logoutLink.on('click', onClickLogoutLink);

    function onClickLogoutLink(e) {

        ModalAlerts.confirm(appName + ' pergunta:', 'Deseja realmente sair do sistema ?', function() {
            window.location = $logoutLink.prop('href');
        });

        return false;
    };

    return {
        moneyMaskOptions : moneyMaskOptions
    };

})(jQuery);