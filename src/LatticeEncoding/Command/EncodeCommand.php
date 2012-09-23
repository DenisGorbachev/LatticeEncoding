<?php

namespace LatticeEncoding\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use LatticeEncoding\Entity\Lattice;
use LatticeEncoding\Entity\Encoder;

class EncodeCommand extends Command
{
    protected function configure() {
        $this
            ->setName('encode')
            ->setDescription('Encode the text using the specified lattice')
            ->addArgument('lattice-file', InputArgument::REQUIRED, 'A file containing the lattice')
            ->addArgument('input', InputArgument::REQUIRED, 'The text to encode')
    ;}

    protected function execute(InputInterface $input, OutputInterface $output) {
        $lattice = new Lattice();
        $lattice->loadFromFile($input->getArgument('lattice-file'));
        $encoder = new Encoder($lattice);
        $encoded = $encoder->encodeAsString($input->getArgument('input'));
        $output->writeln('"'.$encoded.'"');
    }

}
