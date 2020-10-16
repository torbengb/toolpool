<?php
require "common/common.php";
require "common/header.php";
?>

    <div style="float:right;background-color:#eee;sborder:3px double black;xpadding:1em;margin:1em;">
        <?php
      try {
        $statement = $connection->prepare("
        SELECT 'Total users',            COUNT(*) AS count FROM users    WHERE ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL )
        UNION SELECT 'Total tools',      COUNT(*) AS count FROM tools    WHERE ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL ) AND offered=1
        UNION SELECT 'Total loans',      COUNT(*) AS count FROM loans    WHERE ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL )
        UNION SELECT 'Total categories', COUNT(*) AS count FROM taxonomy WHERE ( deleted = '0000-00-00 00:00:00' OR  deleted IS NULL )
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

    <h2>Welcome to your TOOL||POOL!</h2>

    <p>This prototype aims to provide a proof of concept for a community of people wanting to share their tools for DIY
        home-improvement projects.</p>

    <h3>TOOL||POOL helps people to find tools they can borrow, rather than buying them.</h3>

    <p>Imagine this:</p>
    <ol>
        <li><b>You need a tool that you don't have,</b> let's say a nail gun for a fence, or a tile cutter. Do you
            really want to go out and buy one, just for this one use? It's expensive and you will probably not need it
            again for a long time, if ever.
        <li><b>A guy down the road has the tool in his garage.</b> He almost never uses it. He is a member of the
            TOOL||POOL community, and you find his tool offered here on the site. You request to borrow the tool, and he
            says you can pick it up today after work and return it in a week!
        <li><b>You're happy</b> that you didn't have to buy an expensive tool, <b>and he's happy</b> that his tool
            doesn't just collect dust.
    </ol>

    <p>TOOL||POOL helps people build a positive neighborhood. TOOL||POOL is a volunteer community: there are no fees, no
        subscriptions, no payments. You just need to supply your own nails, blades, oil, and other consumables. Don't
        fret about the risk of borrowing your precious tools to strangers&mdash;instead, see it as an opportunity to
        meet new likeminded DIY enthusiasts in your neighborhood!

    <h2>Known bugs</h2>
    <p>Found a bug? Check whether it's already in the <a href="https://github.com/torbengb/toolpool/issues/"
                                                         target="_new">issue tracker on GitHub</a>. If it isn't, <a
                href="https://github.com/torbengb/toolpool/issues/new">please submit an issue!</a>


<?php require "common/footer.php"; ?>