<?php

namespace LatticeEncoding\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use LatticeEncoding\Entity\Lattice;
use LatticeEncoding\Entity\Decoder;

class DecodeCommand extends Command
{
    protected function configure() {
        $this
            ->setName('decode')
            ->setDescription('Decode the text using the specified lattice')
            ->addArgument('lattice-file', InputArgument::REQUIRED, 'A file containing the lattice')
            ->addArgument('input', InputArgument::REQUIRED, 'The text to decode')
    ;}

    protected function execute(InputInterface $input, OutputInterface $output) {
        $lattice = new Lattice();
        $lattice->loadFromFile($input->getArgument('lattice-file'));
        $decoder = new Decoder($lattice);
        $decoded = $decoder->decodeString($input->getArgument('input'));
        $output->writeln('"'.$decoded.'"');
    }

}
