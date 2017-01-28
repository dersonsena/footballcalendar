var Utils = (function($) {

    /**
     * Metodo que retorna uma objeto navivo Date, utilizando como base uma string de Date ou Datetime,
     * podendo ser nos formatos BR ou US
     * @param {string} strDate String de Date ou Datetime
     * @returns {Date}
     */
    function getDateTimeObject(strDate) {

        var dateSplit, timeSplit, date, month, year;
        var dateObj = new Date();

        if(strDate.indexOf('/') !== -1) {

            dateSplit = strDate.split('/');
            timeSplit = dateSplit[2].substring(5);
            year = parseInt(dateSplit[2].substring(0, 4));
            month = parseInt(dateSplit[1]) - 1;

            dateObj.setDate(dateSplit[0]);
            dateObj.setMonth(month);
            dateObj.setFullYear(year);

        } else if(strDate.indexOf('-') !== -1) {

            dateSplit = strDate.split('-');
            timeSplit = dateSplit[2].substring(3);
            date = parseInt(dateSplit[2].substring(0, 2));
            month = parseInt(dateSplit[1]) - 1;

            dateObj.setDate(date);
            dateObj.setMonth(month);
            dateObj.setFullYear(dateSplit[0]);

        }

        if(timeSplit !== '') {
            timeSplit = timeSplit.split(':');
            dateObj.setHours(timeSplit[0]);
            dateObj.setMinutes(timeSplit[1]);
            dateObj.setSeconds(timeSplit[2]);
        }

        return dateObj;

    };

    /**
     * Metodo que retorna uma data no formato BR a partir de um objecto Date
     * @param {Date} dateObject
     * @returns {string}
     */
    function formatDateToBR(dateObject) {
        return ("0" + dateObject.getDate()).slice(-2) + '/' + ("0" + (dateObject.getMonth() + 1)).slice(-2) + '/' + dateObject.getFullYear();
    }

    /**
     * Metodo que testa se um valor passado e nulo ou vazio
     * @param variable
     * @returns {boolean}
     */
    function isNullOrEmpty(variable) {
        return variable === null || variable === '';
    };

    /**
     * Metodo que converte um string monetaria no formato 'xx,xx' para float 'xx.xx'
     * forcando sempre a retornar 2 casas decimais
     * @param string String no formato 'xx,xx'
     * @return number Numero flutuante convertido para calculos
     */
    function parseFloatString(string) {
        var returnValue = string.replace('.', '');
        returnValue = returnValue.replace(',', '.');

        return parseFloat(parseFloat(returnValue).toFixed(2));
    };

    /**
     * Metodo que converte um float, ou um number, para formato brasileiro
     * @param number
     * @returns {string}
     */
    function floatToBRFormat(number) {
        var tmp = number.toFixed(2) + '';
        tmp = tmp.replace('.', '');
        tmp = tmp.replace(/([0-9]{2})$/g, ",$1");

        if( tmp.length > 6 )
            tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");

        if( tmp.length > 9 )
            tmp = tmp.replace(/([0-9]{3}).([0-9]{3}),([0-9]{2})$/g,'.$1.$2,$3');

        return tmp;
    }

    /**
     * Metodo que faz o foco de alguma elemento (Bugfix para webkit)
     * @param HTMLElement element
     */
    function setFocus(element, selectAll) {
        setTimeout(function() {
            element.focus();

            if (selectAll === undefined || selectAll === true)
                element.select();
        }, 100);
    };

    /**
     * Metodo que seleciona todo o texto de um elemento de formulario (Bugfix para webkit)
     * @param HTMLElement element
     */
    function selectAll(element) {
        setTimeout(function() {
            element.select();
        }, 100);
    };

    function truncateString(string, length, suffix) {
        suffix = (suffix ? suffix : '...');

        return $.trim(string).substring(0, length) + suffix;
    };

    return {
        getDateTimeObject : getDateTimeObject,
        isNullOrEmpty : isNullOrEmpty,
        parseFloatString : parseFloatString,
        setFocus : setFocus,
        selectAll : selectAll,
        floatToBRFormat : floatToBRFormat,
        formatDateToBR : formatDateToBR,
        truncateString : truncateString
    }

})(jQuery);