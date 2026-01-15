<table class="table table-bordered">

    <thead>
    <tr>
    <th>Id</th>
    <th>UserID</th>
    <th>Order ID</th>
    <th>Message Html</th>
    <th>Message Text</th>
    <th>Letter</th>
    <th>Email To</th>
    <th>Email From</th>
    <th>Language</th>
    <th>Sent</th>
    <th>Date</th>
    </tr>
    </thead>
    <tbody>
    <?php if($queues): ?>
    <?php foreach($queues as $queue):?>
    <tr>
        <td><?= $queue['id']; ?></td>
        <td><?= $queue['user_id']; ?></td>
        <td><?= $queue['order_id']; ?></td>
        <td><?= $queue['message_html']; ?></td>
        <td><?= $queue['message_text']; ?></td>
        <td><?= $queue['email_to']; ?></td>
        <td><?= $queue['email_from']; ?></td>
        <td><?= $queue['letter']; ?></td>
        <td><?= $queue['lang']; ?></td>
        <td><?= $queue['created']->format("Y-m-d"); ?></td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
<div
