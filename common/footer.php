</div> <!-- end body -->
<div class="footer">
    <div class="navbar">
    <span class="topics">
      || <a href="/index.php"><strong>Home</strong></a>
      || <a href="/tools/list.php"><strong>Tools</strong></a>
      || <a href="/users/list.php"><strong>Members</strong></a>
      || <a href="/loans/list.php"><strong>Loans</strong></a>
      || <a href="/taxonomy/list.php"><strong>Taxonomy</strong></a>
      ||
    </span>
    </div>
    <div class="meta">
    <span>
      || <strong alt="* opens in new page" title="* opens in new page"><a href="https://github.com/torbengb/toolpool#README" target="_new">About</a></strong>
      || <strong alt="* opens in new page" title="* opens in new page"><a href="https://github.com/torbengb/toolpool" target="_new">Github</a></strong>
      || <strong alt="* opens in new page" title="* opens in new page"><a href="https://github.com/torbengb/toolpool/issues?q=is%3Aopen+is%3Aissue+label%3Abug" target="_new">Known bugs</a></strong>
      || <strong alt="* opens in new page" title="* opens in new page"><a href="https://github.com/torbengb/toolpool/issues/new" target="_new">Report a bug</a></strong>
      ||
    </span>
    </div>
</div>
<form method="post" action="/">
    <input type="hidden" name="csrf" value="<?php echo escape($_SESSION['csrf']); ?>">
    <input type="hidden" name="id" value="<?php echo escape($user['id']); ?>">
    <label class="label" for="user"><span class="labeltext">select user:</span>
        <select class="input" name="user" id="user">
          <?php foreach ($users as $row) : ?>
              <option
                      name="user"
                      id="user"
                      value="<?php echo escape($row['id']); ?>"
                  <?php echo(escape($row["id"]) == escape($_SESSION["currentuserid"]) ? "selected='selected'" : NULL) ?>
              ><?php echo escape($row['username']); ?></option>
          <?php endforeach; ?>
        </select>
    </label>
    <button class="button submit" type="submit" name="login" value="login">Switch!</button>
</form>
</body>
</html>
