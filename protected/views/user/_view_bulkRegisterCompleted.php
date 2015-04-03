<?php if(!is_null($users)): ?>
<div class="flash-success">
	Rejestracja seryjna przebiegła pomyślnie. Poniższe zestawienie należy zachować!
</div>
<div class="grid-view">
    <table class="items table table-striped table-condensed">
        <thead>
            <tr>
                <th></th>
                <th>Nazwa użytkownika</th>
                <th>Hasło</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>E-mail</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
                <tr>
                    <td></td>
                    <td style="vertical-align: middle;"><?php echo $user['username']; ?></td>
                    <td style="vertical-align: middle;"><?php echo $user['password']; ?></td>
                    <td style="vertical-align: middle;"><?php echo $user['first_name']; ?></td>
                    <td style="vertical-align: middle;"><?php echo $user['last_name']; ?></td>
                    <td style="vertical-align: middle;"><?php echo $user['email']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>