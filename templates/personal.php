<form id="sharedfirewall" class="section">
	<h2><?php p($l->t('Shared Firewall')); ?></h2>
	<table id="firewallTable" class="grid">
		<thead>
		<tr>
			<th></th>
			<th><?php p($l->t('Path')); ?></th>
			<th><?php p($l->t('Accept')); ?></th>
			<th>&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php $_['firewalls'] = array_merge($_['firewalls'], array('' => array())); ?>
		<?php foreach ($_['firewalls'] as $firewall): ?>
			<tr <?php print_unescaped(isset($firewall['id']) ? 'data-id="'.$firewall['id'].'" data-shareid="'.$firewall['shareid'].'"' : 'id="addRecord"'); ?>>
				<td class="status">
					<?php if (isset($firewall['status'])): ?>
						<span class="<?php p(($firewall['status']) ? 'success' : 'error'); ?>"></span>
					<?php endif; ?>
				</td>
				<td class="path">
					<?php if (!isset($firewall['id'])): ?>
						<select id="selectPath" >
							<option value="" disabled selected
									style="display:none;"><?php p($l->t('Add Record')); ?></option>
							<?php foreach ($_['shares'] as $share): ?>
								<option value="<?php p($share['id']); ?>"><?php p($share['path']); ?></option>
							<?php endforeach; ?>
						</select>
					<?php else: ?>
						<label><?php p($firewall['path']); ?></label>
					<?php endif; ?>
				</td>
				<td class ="accept">
					<?php if (!isset($firewall['id'])): ?>
					<?php else: ?>
						<input type="text" name="accept" class="ipaddress"
							   value="<?php p(isset($firewall['accept']) ? $firewall['accept'] : ''); ?>"
							   placeholder="<?php p($l->t('IP Address')); ?>" />
					<?php endif; ?>
				</td>
				<td
					<?php if (isset($firewall['id'])): ?>class="remove"
					<?php else: ?>style="visibility:hidden;"
					<?php endif ?>><img alt="<?php p($l->t('Delete')); ?>"
										title="<?php p($l->t('Delete')); ?>"
										class="svg action"
										src="<?php print_unescaped(image_path('core', 'actions/delete.svg')); ?>" /></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</form>