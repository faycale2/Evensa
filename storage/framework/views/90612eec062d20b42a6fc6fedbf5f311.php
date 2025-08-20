<?php $__env->startComponent('mail::message'); ?>
# Nouvelle Invitation

Vous avez été invité à rejoindre <?php echo e(config('app.name')); ?>.

**Email:** <?php echo e($email); ?>  
**Rôle:** 


Accepter l'invitation


Ce lien expirera le <?php echo e($expires_at); ?>.

Merci,  
L'équipe 
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\Laravel_project\evensa_project\resources\views/emails/invitation.blade.php ENDPATH**/ ?>