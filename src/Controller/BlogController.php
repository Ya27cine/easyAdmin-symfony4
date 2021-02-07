<?php   

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

    /**
     * @Route("/blog")
     */
class BlogController extends AbstractController{

   /* const POSTS = [
                ['id'=> 1, 'title'=> "Formation Angular", 'slug'=> "Formation-angular"],
                ['id'=> 2, 'title'=> "Formation ReactJs", 'slug'=> "Formation-reactJs"],
                ['id'=> 3, 'title'=> "Formation Symfony", 'slug'=> "Formation-symfony"],
                ['id'=> 4, 'title'=> "Formation Git", 'slug'=> "Formation-git"],
    ];*/

    /**
     * @Route("/add",name="add-post", methods={"POST"})
     */
    public function add(Request $request){
        $serializer = $this->get('serializer');
        $post = $serializer->deserialize($request->getContent(), Post::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist( $post );
        $em->flush();

        return $this->json($post);
    }


    /**
     * @Route("/{page}", defaults={"page": 1}, name="get-all-by-id", methods={"GET"})
     */
    public function index($page = 1){

        $reposi = $this->getDoctrine()->getRepository(Post::class);
        $posts = $reposi->findAll();

        return new JsonResponse([
            'page' => $page,
            'data' => array_map(function(Post $post){
                        return [
                            'link' => $this->generateUrl('get-one-by-id', ['id' => $post->getId() ]),
                            'user' => $post->getAutor(),
                            'title' => $post->getTitle(),
                            'content' => $post->getContent(),
                            'date creation' => $post->getPublished(),

                        ];
            }, $posts)
        ]);
    }

    /**
     * @Route("/post/{id}", name="get-one-by-id", requirements={"id": "\d+"}, methods={"GET"})
     */
    public function postById(Post $post){  // id == post.id then get item 

       // $reposi = $this->getDoctrine()->getRepository(Post::class);
       // $post = $reposi->find($id);

          /*$index =  array_search($id, array_column(self::POSTS, 'id'));
          return new JsonResponse([
            self::POSTS[ $index ]
        ]);  */

        return $this->json($post);
    }

     /**
     * @Route("/post/{autor}", name="get-one-by-autor", methods={"GET"})
     * @ParamConverter("post", class="App:Post", options={"mapping": {"autor": "autor"}} )
     */
    public function postByAutor($post){   
         return $this->json( $post);
     }




      /**
     * @Route("/post/{id}", name="delet-post", methods={"DELETE"})
     */
    public function destroy(Post $post){  

        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
 
         return $this->json(null, 204);
     }


}




