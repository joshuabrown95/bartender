<!DOCTYPE html>
<html>
  <head>
    <title>Choose a drink</title>
  </head>
  <body>
    <h1>Choose drink(s)</h1>
    <table>
      <thead>
        <tr>
          <th>Drink #</th>
          <th>Drink Name</th>
          <th>Fill Order!</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $item): ?>
          <tr>
            <td><?php echo $item['id']; ?></td>
            <td><?php echo $item['title']; ?></td>
            <td>
              <form method="POST">
                <input name="id" type="hidden" value="<?php echo $item['id']; ?>">
                <button type="submit">Order Drink</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p>If you are the bartender then what are you doing here?! You don't need to order anything! <a href="/fillorders">Make some drinks!</a>.</p>
    <p>Return to the entrance <a href="/">here</a></p>
  </body>
</html>