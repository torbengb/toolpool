<?php
require "common/common.php";
require "common/header.php";

$numoffers    = 0;
$numlends     = 0;
$numlendspast = 0;
$numloans     = 0;

if (isset($_SESSION['currentuserid'])) {
    $userid = $_SESSION['currentuserid'];
    $statement = $connection->prepare("
                SELECT 'You are offering',      COUNT(*) AS count FROM tools WHERE owner=:userid    AND ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL ) AND offered=1
                UNION SELECT 'You are lending', COUNT(*) AS count FROM loans WHERE owner=:userid    AND ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL ) AND active=1
                UNION SELECT 'Past lending',    COUNT(*) AS count FROM loans WHERE owner=:userid    AND ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL ) AND active IS NULL
                UNION SELECT 'You are loaning', COUNT(*) AS count FROM loans WHERE loanedto=:userid AND ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL ) AND active=1
            ");
    $statement->bindValue('userid', $userid);
    $statement->execute();
    $stats = $statement->fetchAll();
    $numoffers=$stats[0][1][0];
    $numlends =$stats[1][1][0];
    $numlendspast =$stats[2][1][0];
    $numloans =$stats[3][1][0];
}
?>

    <div style="float:right;background-color:#eee;margin:1em;">
        <?php
      try {
        $statement = $connection->prepare("
        SELECT 'Total users',       COUNT(*) AS count FROM users   WHERE ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL )
        UNION SELECT 'Total tools', COUNT(*) AS count FROM tools t JOIN users u ON u.id = t.owner WHERE offered=1 AND ( t.deleted = '0000-00-00 00:00:00' OR t.deleted IS NULL ) AND ( u.deleted = '0000-00-00 00:00:00' OR u.deleted IS NULL )
        UNION SELECT 'Total loans', COUNT(*) AS count FROM loans   WHERE ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL ) -- AND active=1
        -- UNION SELECT 'Total categories', COUNT(*) AS count FROM taxonomy WHERE ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL )
        ");
        $statement->execute();
        $result = $statement->fetchAll();
      } catch (PDOException $error) {
        showMessage(__LINE__, __FILE__, $sql . "<br>" . $error->getMessage());
      }
      ?>
        <table>
            <tr>
                <td colspan="2" align="center" style="color:red;background-color:yellow;"><b>!!UNDER CONSTRUCTION!!</b>
                    <br>No warranties, neither expressed<br> nor implied. Use at your own peril.
                </td>
            </tr>
            <tr>
                <th colspan=2 align="center">Statistics</th>
            </tr>
            <?php foreach ($result as $row) : ?>
              <tr>
                  <td><?php echo $row["0"]; ?></td>
                  <td><?php echo $row["count"]; ?></td>
              </tr>
          <?php endforeach; ?>
        </table>
    </div>

    <h2>Welcome to your TOOL||POOL<?php if (isset($_SESSION['currentusername'])) echo ", " . $_SESSION['currentusername'] ?>!</h2>

<?php if (isset($_POST['logout'])) : ?>
    <blockquote class="success">You have been logged out. See you soon!</blockquote>
<?php endif; ?>

<?php if (isset($_SESSION['currentusername'])) : ?>
    <p> You are <a href="/profile/tools.php">offering    <span style="font-size: 200%"><?php echo $numoffers;    ?></span></a> tools. <a href="tools/new.php">Add another!</a><br>
        You are <a href="/profile/loan-out.php" >lending <span style="font-size: 200%"><?php echo $numlends;     ?></span></a> tools to others,
            plus <a href="/profile/loan-out-history.php"><span style="font-size: 200%"><?php echo $numlendspast; ?></span> in the past</a>.
            <?php
            if     ($numlends + $numlendspast > 5) echo "Great job!";
            elseif ($numlends + $numlendspast > 0) echo "Good start!";
            elseif ($numlends + $numlendspast = 0) echo "That's okay.";
            ?><br>
        You are <a href="/profile/loan-in.php"  >loaning  <span style="font-size: 200%"><?php echo $numloans;  ?></span></a> tools from others.<br>
    </p>
<?php else : ?>

    <p>This prototype is <span style="background-color: yellow">a community platform for people to share their tools for
        DIY home-improvement projects.</span>
        <a href="/profile/login.php?action=registers">Register</a> if you're not a user already, or just
        <a href="tools/list.php">browse all the tools</a> that are available already. You can also
        <a href="/profile/tools.php">offer your own tools</a> for the benefit of your neighbors and local community.

    <h3>TOOL||POOL helps people to find tools they can borrow, rather than buying them.</h3>

    <p>Imagine this:</p>
    <ol>
        <li><b>You need a tool that you don't have,</b> let's say a nail gun for a fence, or a tile cutter. Do you
            really want to go out and buy one, just for this one use? It's expensive and you will probably not need it
            again for a long time, if ever.
        <li><b>A guy down the road has the tool in his garage.</b> He almost never uses it. You find his tool offered
            here on the site because he is a member of the TOOL||POOL community. You request to borrow the tool, and he
            says you can pick it up today after work and return it in a week!
        <li><b>You're happy</b> that you didn't have to buy an expensive tool, <b>and he's happy</b> that his tool
            doesn't just collect dust.
    </ol>

    <p>TOOL||POOL helps people build a positive neighborhood. <span style="background-color: yellow">TOOL||POOL is a volunteer community:
        there are no fees, no subscriptions, no payments.</span> You just need to supply your own nails, blades, oil,
        and other consumables. Don't fret about the risk of borrowing your precious tools to strangers&mdash;instead, see it
        as an opportunity to meet new like-minded DIY enthusiasts in your neighborhood!
<?php endif ?>

    <h2>Known bugs</h2>
    <p>Found a bug? Check whether it's already in the
        <a href="https://github.com/torbengb/toolpool/issues/" target="_new">
            issue tracker on GitHub</a>. If it isn't,
        <a href="https://github.com/torbengb/toolpool/issues/new" target="_new">
            please submit an issue!</a>


<?php require "common/footer.php"; ?>
