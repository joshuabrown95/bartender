<!DOCTYPE html>
<html>
  <head>
    <title>Hello Bartender!</title>
  </head>
  <body>
    <h1>Hello Bartender!</h1>
    <?php if (empty($orders)): ?>
      <p>Currently there are no orders</p>
    <?php else: ?>
      <p>Now get them drunk.</p>
      <table>
        <thead>
        <th>Order #</th>
        <th>Drink #</th>
        <th>Respond to orders here</th>
      </thead>
      <tbody>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td><?php echo $order['id']; ?></td>
            <td><?php echo $order['item_id']; ?></td>
            <td>
              <form method="POST">
                <input name="id" type="hidden" value="<?php echo $order['id']; ?>">
                <button type="submit" name="status" value="1">Order FILLED</button>
                <button type="submit" name="status" value="0">Order CANCELED</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
    </table>
  <?php endif; ?>
  <p>If you are a customer, what are you doing here?! <a href="/products">Order something!!</a>.</p>
  <p>Return to the entrance <a href="/">here</a></p>
</body>
</html>