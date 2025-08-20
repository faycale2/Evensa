<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Support - Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        form input, form textarea {
            display: block;
            width: 300px;
            margin-bottom: 15px;
            padding: 8px;
        }
        button {
            padding: 10px 20px;
            cursor: pointer;
        }
        .success {
            color: green;
            margin-bottom: 20px;
        }
        .errors {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <h1>Formulaire de test Support</h1>

    
    <?php if(session('success')): ?>
        <div class="success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    
    <?php if($errors->any()): ?>
        <div class="errors">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    
    <form method="POST" action="<?php echo e(url('/support')); ?>">
        <?php echo csrf_field(); ?>
        <input type="text" name="name" placeholder="Votre nom" value="<?php echo e(old('name')); ?>" required>
        <input type="email" name="email" placeholder="Votre email" value="<?php echo e(old('email')); ?>" required>
        <textarea name="message" placeholder="Votre message" required><?php echo e(old('message')); ?></textarea>
        <button type="submit">Envoyer</button>
    </form>
	<p><?php echo e(session('data')); ?></p> 

</body>
</html>
<?php /**PATH C:\Laravel_project\evensa_project\resources\views/contact.blade.php ENDPATH**/ ?>