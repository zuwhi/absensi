<!DOCTYPE html>
<html>

<head>
    <title>Employee List</title>
</head>

<body>
    <h1>Employee List</h1>
    <a href="/employees/create">Add Employee</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $employee) : ?>
                <tr>
                    <td><?= $employee['id'] ?></td>
                    <td><?= $employee['name'] ?></td>
                    <td><?= $employee['email'] ?></td>
                    <td>
                        <a href="/employees/<?= $employee['id'] ?>">View</a>
                        <a href="/employees/<?= $employee['id'] ?>/edit">Edit</a>
                        <form action="/employees/<?= $employee['id'] ?>" method="post" style="display: inline;">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>