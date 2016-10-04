<section class="content">
	<div class="row">
		<form role="form" class="form-horizontal" method="post" ENCTYPE="multipart/form-data" action="<?=$action?>">
			<div class="col-lg-7">
				<div class="box box-primary">
					<!-- form start -->
					<div class="box-body">
						<?php $errors = $f3->get('errors'); ?>
						<div class="form-group<?= (isset($errors['login']))? ' has-error' : '';?>">
							<label class="col-lg-3 control-label">Логин:</label>
							<div class="col-lg-8">
								<input type="text" name="login" class="form-control" placeholder="Логин" value="<?=$user->login;?>">
								<?php if(isset($errors['login'])):?>
									<p class="text-danger"><i class="fa fa-times-circle-o"></i> <?= $errors['login']; ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group<?= (isset($errors['email']))? ' has-error' : '';?>">
							<label class="col-lg-3 control-label">Email:</label>
							<div class="col-lg-8">
								<input type="text" name="email" class="form-control" placeholder="Email" value="<?=$user->email;?>">
								<?php if(isset($errors['email'])):?>
									<p class="text-danger"><i class="fa fa-times-circle-o"></i> <?= $errors['email']; ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group<?= (isset($errors['password']))? ' has-error' : '';?>">
							<label class="col-lg-3 control-label">Пароль:</label>
							<div class="col-lg-8">
								<input type="password" name="password" class="form-control">
								<p>Не менее 6 символов</p>
								<?php if(isset($errors['password'])):?>
									<p class="text-danger"><i class="fa fa-times-circle-o"></i> <?= $errors['password']; ?></p>
								<?php endif; ?>
							</div>
							<label class="col-lg-3 control-label">Повторите пароль:</label>
							<div class="col-lg-8">
								<input type="password" name="password2" class="form-control">
								<?php if(isset($errors['password2'])):?>
									<p class="text-danger"><i class="fa fa-times-circle-o"></i> <?= $errors['password2']; ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group<?= (isset($errors['group']))? ' has-error' : '';?>">
							<label class="col-lg-3 control-label">Группа:</label>
							<div class="col-lg-8">
								<select name="users_group" class="form-control">
									<?php foreach ($groups->find() as $group){ ?>
										<option value="<?= $group->id_group ?>" <?= ($group->id_group == $user->id_group)? 'selected' : '' ?>>
											<?= $group->name ?></option>
									<?php } ?>
								</select>
								<?php if(isset($errors['group'])):?>
									<p class="text-danger"><i class="fa fa-times-circl3o"></i> <?= $errors['group']; ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="form-group<?= (isset($errors['image']))? ' has-error' : '';?>">
							<label class="col-lg-3 control-label">Фотография:</label>
							<div class="col-lg-8">
								<?php  $avatar = $user->avatar;
								if (empty($avatar)) {
								$path = $f3->get("homeurl") . '/inc/i/user.jpg';
								} else {
								$path = $f3->get("homeurl") . '/inc/i/avatar/' . $avatar;
								}
								?>
								<img src="<?= $path ?>" class="user-image img-circle" alt="User Image">
								<input type="hidden" name="MAX_FILE_SIZE" />
								<input name="userfile" type="file" class="form-control" />
								<?php if(isset($errors['image'])):?>
									<p class="text-danger"><i class="fa fa-times-circl3o"></i> <?= $errors['image']; ?></p>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<div class="pull-right">
							<input type="submit" value="Сохранить" class="btn btn-primary">
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="col-lg-5">
			<div class="box">
				<div class="box-body">
					<?php
					if($user->id_user) {
						$agent = $user->getAgent();

						if (isset($agent) and $agent->id_sales_agent > 0) {
							?>
							<p>
								<a href="<?= $f3->get("homeurl") ?>/admin/agents/editagent/<?= $agent->id_sales_agent ?>"
								   class="form-control btn btn-primary">
									Смотреть инф-ю об агенте</a>
							</p>
						<?php } else { ?>
							<p>
								<a href="<?= $f3->get("homeurl") ?>/admin/agents/addagent?user=<?= $user->id_user ?>"
								   class="form-control btn btn-primary">
									Добавить инф-ю об агенте</a>
							</p>
						<?php }
					}?>
				</div>
			</div>
		</div>
	</div>
</section>