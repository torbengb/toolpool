<?php
require "common/common.php";
require "common/header.php";
?>

<p style="color:red;background-color:yellow;"><b>!! UNDER CONSTRUCTION !!</b> No warranties, neither expressed nor implied. Use at your own peril.

<h2>Welcome to your tool pool!</h2>

<div style="float:right;background-color:#eee;sborder:3px double black;xpadding:1em;margin:1em;">
<?php 
try {
  $sql = "SELECT 'Total users', COUNT(*) as count FROM users";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}

$sql = "SELECT 'Total users', COUNT(*) as count FROM users WHERE deleted = '0000-00-00 00:00:00'
UNION SELECT 'Total tools', COUNT(*) as count FROM tools WHERE deleted = '0000-00-00 00:00:00' AND offered=1
UNION SELECT 'Total loans', COUNT(*) as count FROM loans WHERE deleted = '0000-00-00 00:00:00'
UNION SELECT 'Total categories', COUNT(*) as count FROM taxonomy WHERE deleted = '0000-00-00 00:00:00'
";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
?>
  <table>
    <tr><th colspan=2 align="center">Statistics</th></tr>
    <?php foreach ($result as $row) : ?>
    <tr><td><?php echo $row["0"]; ?></td>
        <td><?php echo $row["count"]; ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>

<p>This prototype of <b>Tool Pool</b> aims to provide a proof of concept for a community of people wanting to share their tools for DIY home-improvement projects.
<p><b>Imagine this:</b>
<ul>
<li>You need a tool that you don't have, let's say a nail gun for a fence, or a tile cutter. Do you really want to go out and buy one, just for this one use? It's expensive and you will probably not need it again for a long time, if ever.
<li>A guy down the road has the tool in his garage. He almost never uses it. He is a member of the Tool Pool community, and you find his tool offered here on the site. You request to borrow the tool, and he says you can pick it up today after work and return it in a week!
<li>You're happy that you didn't have to buy an expensive tool, and he's happy that his tool doesn't collect dust.
</ul>

<p><b>Tool Pool helps people to find tools they can borrow,</b> rather than buying them. Tool Pool helps people build a positive neighborhood. Tool Pool is a volunteer community: there are no fees, no subscriptions, no payments. You just need to supply your own nails, blades, oil, and other consumables. Don't fret about the risk of borrowing your precious tools to strangers&mdash;instead, see it as an opportunity to meet new likeminded DIY enthusiasts!

<h2>Known bugs</h2>
<p>See the <a href="https://github.com/torbengb/toolpool/issues/" target="_new">issue tracker on GitHub</a>.
</p>

<h2>Features</h2>
<p>These are some of the ideas to be explored with this prototype, sorted by approximate order of planned implementation:
<ul>
<li>add users
<li>modify users
<li>add tools
<li>modify tools
<li>find a tool
<li>request a tool loan
<li>accept/reject a tool loan
<li>record a tool pick-up
<li>record a tool return
<li>chat between users
<li>commenting, flagging, reporting on users and tools for moderator attention
</ul>

<h2>Bugs?</h2>
<p><a href=" href="https://github.com/torbengb/toolpool/issues/new">Please submit an issue!</a>

<?php require "common/footer.php"; ?>