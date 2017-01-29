var MatchesForm = (function($) {

    var dataSheet = [];
    var $tableDataSheet = document.querySelector('table#dataSheet');

    if (dataSheetUpdate.length > 0) {

        for (var i in dataSheetUpdate) {
            var playerId = parseInt(dataSheetUpdate[i].player_id);
            var player = JSON.parse(document.querySelector('tr#player-' + playerId + ' input[type=hidden]').value);

            addPlayerInDataSheet(player);
        }

    }

    function addPlayerInDataSheet(player) {

        if (playerExistsInDataSheet(player)) {
            ModalAlerts.alert(appName + ' diz:', 'Você já adicionou o atleta <strong>' + player.name + '</strong> na lista.');
            return;
        }

        $tableDataSheet.querySelector('tfoot tr').classList.add('hide');

        var $trPlayer = document.querySelector('tr#player-' + player.id);
        var $addButton = $trPlayer.querySelector('button.btn-add-player');

        dataSheet.push(player);
        addPlayerInTable(player);

        $trPlayer.classList.add('warning');
        $addButton.disabled = true;
    };

    function addPlayerInTable(player) {

        var goals = 0;
        var assists = 0;

        if (dataSheetUpdate.length > 0) {
            var info = getPlayerDataSheet(player);
            goals = info.goals;
            assists = info.assists;
        }

        var tr = "<tr id='datasheet-"+ player.id +"'>" +
                 "    <td>" +
                 "        <button type='button' tabindex='-1' class='btn btn-danger' onclick='MatchesForm.deletePlayer("+ JSON.stringify(player) +")'><i class='fa fa-trash'></i></button>" +
                 "        <input type='hidden' name='MatchDatasheet[player_id][]' value='"+ player.id +"'>" +
                 "    </td>" +
                 "    <td>"+ player.name +"</td>" +
                 "    <td><input type='number' name='MatchDatasheet[goals][]' value='"+ goals +"' class='form-control text-center'></td>" +
                 "    <td><input type='number' name='MatchDatasheet[assists][]' value='"+ assists +"' class='form-control text-center'></td>" +
                 "</tr>";

        $tableDataSheet.querySelector('tbody').innerHTML += tr;
    };

    function deletePlayer(player) {

        for (var i in dataSheet) {
            if (dataSheet[i].id == player.id) {
                dataSheet.splice(i, 1);
                break;
            }
        }

        if (dataSheet.length === 0)
            $tableDataSheet.querySelector('tfoot tr').classList.remove('hide');

        var $trPlayer = document.querySelector('tr#player-' + player.id);
        var $addButton = $trPlayer.querySelector('button.btn-add-player');
        $trPlayer.classList.remove('warning');
        $addButton.disabled = false;

        var $trDataSheet = document.querySelector('tr#datasheet-' + player.id);
        $trDataSheet.parentNode.removeChild($trDataSheet);
    };

    function playerExistsInDataSheet(player) {
        if (dataSheet.length === 0)
            return false;

        for (var i in dataSheet) {
            if (dataSheet[i].id == player.id)
                return true;
        }

        return false;
    };

    function getPlayerDataSheet(player) {
        if (dataSheetUpdate.length == 0)
            return null;

        for (var i in dataSheetUpdate) {
            if (dataSheetUpdate[i].player_id == player.id)
                return dataSheetUpdate[i];
        }

        return null;
    }

    return {
        addPlayerInDataSheet : addPlayerInDataSheet,
        deletePlayer : deletePlayer
    };

})(jQuery);