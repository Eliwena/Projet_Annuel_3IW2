<?php
use \App\Core\Framework;
use \App\Services\Translator\Translator;
use \App\Repository\Users\UserGroupRepository;
?>
<section class="content">

    <h1><?= Translator::trans('admin_user_list_title'); ?></h1>
    <a href="<?= Framework::getUrl('app_admin_user_add'); ?>" class="btn btn-primary-outline pull-right"><i class="fas fa-plus-circle"></i> <?= Translator::trans('admin_user_list_add_user'); ?></a>

    <?php $this->include('error.tpl') ?>

    <div class="table-admin">
        <table id="table_members" class="display table" style="width:100%">
            <thead>
            <tr>
                <th><?= Translator::trans('admin_table_id'); ?></th>
                <th><?= Translator::trans('firstname'); ?></th>
                <th><?= Translator::trans('name'); ?></th>
                <th><?= Translator::trans('email'); ?></th>
                <th><?= Translator::trans('group'); ?></th>
                <th><?= Translator::trans('language'); ?></th>
                <th class="center"><?= Translator::trans('admin_table_action'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (($users ? $users : []) as $user) { ?>
                <tr>
                    <td><?= $user['id']; ?></td>
                    <td><?= $user['firstname']; ?></td>
                    <td><?= $user['lastname']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td><?php foreach(UserGroupRepository::getGroupsByUserId($user['id']) ? UserGroupRepository::getGroupsByUserId($user['id']) : [] as $group) { echo '<span class="badge ' .  ($group['groupId']['name'] == _SUPER_ADMIN_GROUP ? 'badge-red' : '') .'">' . $group['groupId']['description'] . '</span>' ?? null; }?></td>
                    <td><?= $user['country']; ?></td>
                    <td class="center">
                        <a class="btn btn-small btn-warning" href="<?= Framework::getUrl('app_admin_user_edit', ['id' => $user['id']]); ?>"><i class="fas fa-edit"></i> EDITER</a>
                        <?php if($_user->getId() != $user['id']) { ?><a class="btn btn-small btn-delete-outline" href="<?= Framework::getUrl('app_admin_user_delete', ['id' => $user['id']]); ?>"><i class="fas fa-trash"></i> SUPPRIMER</a><?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
            <th><?= Translator::trans('admin_table_id'); ?></th>
            <th><?= Translator::trans('firstname'); ?></th>
            <th><?= Translator::trans('name'); ?></th>
            <th><?= Translator::trans('email'); ?></th>
            <th><?= Translator::trans('group'); ?></th>
            <th><?= Translator::trans('language'); ?></th>
            <th class="center"><?= Translator::trans('admin_table_action'); ?></th>
            </tfoot>
        </table>
    </div>

</section>
<script type="text/javascript">
    $(function () {
        var datatable = $('#table_members').DataTable({
            "language": {
                "url": "<?= Framework::getResourcesPath('json/' . Translator::getLocale() . '.datatables.json'); ?>",
                "searchPlaceholder": "Rechercher un élèment"
            },
            "bLengthChange": false,
            "info": false,
            "paginate": false,
            "sDom": 'Bfrtip',
        });
    });
</script>

