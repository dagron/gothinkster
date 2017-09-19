<?php

namespace spec\AppBundle\Provider;

use AppBundle\Provider\UserTokenViewProvider;
use AppBundle\ReadModel\View\UserTokenView;
use Core\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserTokenViewProviderSpec extends ObjectBehavior
{
    function let(JWTEncoderInterface $JWTEncoder)
    {
        $this->beConstructedWith($JWTEncoder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserTokenViewProvider::class);
    }

    function it_returns_user_token_view_based_on_given_user(User $user, JWTEncoderInterface $JWTEncoder)
    {
        $token = 'some-token';
        $JWTEncoder->encode()->willReturn($token);

        $this->provide($user)->shouldBeLike(new UserTokenView(
            $user->getEmail(),
            $token,
            $user->getUsername(),
            $user->getBio(),
            $user->getImage()
        ));
    }
}
