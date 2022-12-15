use Symfony\Component\Security\Core\SecurityContext;
 
 class UserType extends AbstractType
 {
  
     private $securityContext;
  
     public function __construct(SecurityContext $securityContext)
     {
         $this->securityContext = $securityContext;
     }
  
     public function buildForm(FormBuilder $builder, array $options)
     {
         // Current logged user
         $user = $this->securityContext->getToken()->getUser();
  
         // Add fields to the builder
     }
  
     public function getDefaultOptions(array $options)
     {
         return array(
             'required'   => false,
             'data_class' => 'Acme\HelloBundle\Entity\User'
         );
     }
  
     public function getName()
     {
         return 'user_type';
     }
 }
 ###
 services:
     form.type.user:
         class: Acme\HelloBundle\Form\Type\UserType
         arguments: ["@security.context"]
         tags:
             - { name: form.type, alias: user_type }
 ###
 $form = $this->createForm($this->get('form.type.user'), $data);