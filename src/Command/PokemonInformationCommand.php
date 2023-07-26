<?php

declare(strict_types=1);

namespace Synolia\Bundle\PokemonBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Oro\Bundle\IntegrationBundle\Entity\Channel;
use Oro\Bundle\IntegrationBundle\Provider\Rest\Client\RestClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Synolia\Bundle\PokemonBundle\Constant\PokemonConstant;
use Synolia\Bundle\PokemonBundle\Entity\Pokemon;
use Synolia\Bundle\PokemonBundle\Provider\PokemonTransport;

class PokemonInformationCommand extends Command
{
    private const BATCH_SIZE = 20;

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected PokemonTransport $transport
    ) {
        parent::__construct($this->getDefaultName());
    }

    public static function getDefaultName(): string
    {
        return 'synolia:pokemon:import:information';
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Pokemon API');
        $io->info('Let\'s start downloading the pokemon information :) this might take a while.');

        $pokemons = $this->getPokemonListFromDatabase();
        if (0 === \count($pokemons)) {
            $io->warning('There is no pokemon list information to fetch');

            return Command::FAILURE;
        }

        $channel = $this->getChannel();
        if (!$channel instanceof Channel) {
            $io->warning('There is no pokemon api integration');

            return Command::FAILURE;
        }

        $this->transport->init($channel->getTransport());

        $bar = $io->createProgressBar(\count($pokemons));

        $client = $this->getClient();
        foreach ($pokemons as $index => $pokemon) {
            /** @var string $code */
            $code = $pokemon->getCode();
            $result = $client->getJSON($code);

            $pokemon->setImage($this->getImage($result));
            $pokemon->setType($this->getFirstType($result));

            if (($index + 1) % self::BATCH_SIZE === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
            $bar->advance();
        }

        $this->entityManager->flush();
        $this->entityManager->clear();

        $io->info('');
        $io->success('Pokemon information obtained');

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->setDescription(
            'Fetch pokemon information from Pokemon API'
        );
    }

    /**
     * @return Pokemon[]
     *
     * Get information from only 20 pokemons to not overcharge the api
     */
    private function getPokemonListFromDatabase(): array
    {
        return $this->entityManager->getRepository(Pokemon::class)
            ->findBy(['image' => null], ['id' => 'ASC'], self::BATCH_SIZE);
    }

    private function getChannel(): ?Channel
    {
        return $this->entityManager->getRepository(Channel::class)->findOneBy([
            'name' => PokemonConstant::CHANNEL_NAME,
            'type' => PokemonConstant::CHANNEL_TYPE,
        ]);
    }

    private function getClient(): RestClientInterface
    {
        return $this->transport->getClient();
    }

    private function getImage(array $result): string
    {
        return $result['sprites']['versions']['generation-v']['black-white']['animated']['front_default'] ??
            $result['sprites']['other']['official-artwork']['front_default'] ??
            $result['sprites']['front_default'];
    }

    private function getFirstType(array $result): string
    {
        return $result['types'][0]['type']['name'];
    }
}
