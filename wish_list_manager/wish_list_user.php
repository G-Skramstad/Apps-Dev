<?php require_once '../view/header.php'; ?>
<br>

<?php if (empty($wishLists)) : ?>
    <p>No wish lists found.</p>
    <?php if ($userID == $ListuserID || $userRoleID == 2) : ?>
    <p>would you like to create one?</p>
    <?php include_once 'create_new_list.php';?>
    <?php endif?>
<?php else : ?>
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Wish List Description</th>
                <th>Items</th>
                <th>Date Created</th>
                <th>Is Active</th>
                <th>View</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wishLists as $wishList) : ?>
                <tr>
                    <td><?php echo $wishList->getName(); ?></td>
                    <td><?php echo $wishList->getDescription(); ?></td>
                    <td><?php echo $wishList->getItems(); ?></td>
                    <td><?php echo $wishList->getDateCreated(); ?></td>
                    <td><?php echo $wishList->getIsActive() ? 'Yes' : 'No'; ?></td>
                    <td>
                        <form action="wish_list_manager/index.php" method="POST">
                            <input type="hidden" name="controllerRequest" value="View_list_Items" />
                            <input type="hidden" name="wishListID" value="<?php echo $wishList->getId(); ?>" />
                            <input type="submit" value="View">
                        </form>
                    </td>
                    <td>
                        <?php if ($userID == $wishList->getUserID() || $userRoleID == 2) : ?>
                            <form action="wish_list_manager/index.php" method="POST">
                                <input type="hidden" name="controllerRequest" value="edit_list_items" />
                                <input type="hidden" name="wishListID" value="<?php echo $wishList->getId(); ?>" />
                                <input type="submit" value="Edit">
                            </form>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($userID == $wishList->getUserID() || $userRoleID == 2) : ?>
                            <form action="wish_list_manager/index.php" method="POST">
                                <input type="hidden" name="controllerRequest" value="delete_list" />
                                <input type="hidden" name="wishListID" value="<?php echo $wishList->getId(); ?>" />
                                <input type="submit" value="Delete">
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once '../view/footer.php'; ?>
