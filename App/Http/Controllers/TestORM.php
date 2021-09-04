<?php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\ORM\Collection;

class TestORM extends Controller
{
    public function testView(): void
    {
        $this->firstAndLastTest();
        echo '<hr/>';
        $this->firstFilterAndLastFilterTest();
        echo '<hr/>';
        $this->mapTest();
        echo '<hr/>';
        $this->filterTest();
        echo '<hr/>';
        $this->onlyTest();
        echo '<hr/>';
        $this->exceptTest();
        echo '<hr/>';
        $this->hasTest();
        echo '<hr/>';
        $this->reverseTest();
        echo '<hr/>';
        $this->valueTest();
        echo '<hr/>';
        $this->valuesTest();
        echo '<hr/>';
        $this->chunkTest();
        echo '<hr/>';
        $this->sliceTest();
        echo '<hr/>';
        $this->takeTest();
        echo '<hr/>';
        $this->skipTest();
        echo '<hr/>';
        $this->flipTest();
        echo '<hr/>';
        $this->shuffleTest();
        echo '<hr/>';
        $this->groupTest();
        echo '<hr/>';
        $this->uniqueTest();
        echo '<hr/>';
        $this->duplicateTest();
        echo '<hr/>';
        $this->sortByValuesAscTest();
        echo '<hr/>';
        $this->sortByValuesDescTest();
        echo '<hr/>';
        $this->sortByKeyAscTest();
        echo '<hr/>';
        $this->sortByKeyDescTest();
        echo '<hr/>';
        $this->addTest();
        echo '<hr/>';
        $this->unshiftTest();
        echo '<hr/>';
        $this->countTest();
    }

    private function firstAndLastTest(): void
    {
        $collection = new Collection([1, 2, 3, 4]);
        $this->showCode('$collection = new Collection([1, 2, 3, 4]);');

        $this->showCode('var_dump($collection->first());');
        var_dump($collection->first());

        $this->showCode('var_dump($collection->last());');
        var_dump($collection->last());
    }

    private function firstFilterAndLastFilterTest(): void
    {
        $collection = new Collection([1, 2, 3, 4]);
        $this->showCode('$collection = new Collection([1, 2, 3, 4]);');

        $firstFilter = $collection->firstFilter(function ($item, $key) {
            return $item > 2;
        });
        $firstFilterCode = <<<EOD
        \$collection->firstFilter(function (\$item, \$key) {
            return \$item > 2;
        });
        EOD;
        $this->showCode($firstFilterCode);
        var_dump($firstFilter);


        $collection = new Collection([1, 2, 3, 4]);
        $this->showCode('$collection = new Collection([1, 2, 3, 4]);');

        $lastFilter = $collection->lastFilter(function ($item, $key) {
            return $item > 2;
        });
        $lastFilterCode = <<<EOD
        \$collection->lastFilter(function (\$item, \$key) {
            return \$item > 2;
        });
        EOD;
        $this->showCode($lastFilterCode);
        var_dump($lastFilter);
    }

    private function mapTest(): void
    {
        $collection = new Collection([1, 2, 3, 4]);
        $this->showCode('$collection = new Collection([1, 2, 3, 4]);');

        $mappedCollection = $collection->map(function ($item, $key) {
            return $item = $item + 1;
        });
        $mappedCollectionCode = <<<EOD
        \$collection->map(function (\$item, \$key) {
            return \$item = \$item + 1;
        });
        EOD;

        $this->showCode($mappedCollectionCode);
        var_dump($mappedCollection->get());
    }

    private function filterTest(): void
    {
        $collection = new Collection([1, 2, 3, 4]);
        $this->showCode('$collection = new Collection([1, 2, 3, 4]);');

        $filteredCollection = $collection->filter(function ($item, $key) {
            return $item > 2;
        });
        $filteredCollectionCode = <<<EOD
        \$collection->filter(function (\$item, \$key) {
            return \$item > 2;
        });
        EOD;

        $this->showCode($filteredCollectionCode);
        var_dump($filteredCollection->get());
    }

    private function onlyTest(): void
    {
        $collection = new Collection([
            'id' => 1,
            'username' => 'endriu3314',
            'birth' => '13/03/2003'
        ]);
        $collectionCode = <<<EOD
        \$collection = new Collection([
            'id' => 1,
            'username' => 'endriu3314',
            'birth' => '13/03/2003'
        ]);
        EOD;
        $this->showCode($collectionCode);

        $onlyCollection = $collection->only('id', 'username');
        $onlyCollectionCode = <<<EOD
        \$onlyCollection = \$collection->only('id', 'username');
        EOD;

        $this->showCode($onlyCollectionCode);
        var_dump($onlyCollection->get());
    }

    private function exceptTest(): void
    {
        $collection = new Collection([
            'id' => 1,
            'username' => 'endriusolo',
            'password' => 'Password1234',
            'birthdate' => '13/03/2003'
        ]);
        $collectionCode = <<<EOD
        \$collection = new Collection([
            'id' => 1,
            'username' => 'endriusolo',
            'password' => 'Password1234',
            'birthdate' => '13/03/2003'
        ]);
        EOD;
        $this->showCode($collectionCode);

        $collectionExcept = $collection->except('password');
        $collectionExceptCode = <<<EOD
        \$collectionExcept = \$collection->except('password');
        EOD;

        $this->showCOde($collectionExceptCode);
        var_dump($collectionExcept->get());
    }

    private function hasTest(): void
    {
        $collection = new Collection([
            'id' => 1,
            'username' => 'endriusolo',
            'password' => 'Password1234'
        ]);
        $collectionCode = <<<EOD
        \$collection = new Collection([
            'id' => 1,
            'username' => 'endriusolo',
            'password' => 'Password1234'
        ]);
        EOD;
        $this->showCode($collectionCode);

        $this->showCode("\$collection->has('email', 'birthdate')");
        var_dump($collection->has('email', 'birthdate'));
    }

    private function reverseTest(): void
    {
        $collection = new Collection([1, 2, 4, 4]);
        $this->showCode('$collection = new Collection([1, 2, 4, 4]);');

        $this->showCode('$collection->reverse()');
        var_dump($collection->reverse()->get());
    }

    private function valueTest(): void
    {
        $collection = new Collection([
            'id' => 1,
            'username' => 'endriusolo'
        ]);
        $collectionCode = <<<EOD
        \$collection = new Collection([
            'id' => 1,
            'username' => 'endriusolo'
        ]);
        EOD;
        $this->showCode($collectionCode);

        $this->showCode('$collection->value("username")');
        var_dump($collection->value('username'));
    }

    private function valuesTest(): void
    {
        $collection = new Collection([
            'id' => 1,
            'username' => 'endriusolo',
            'password' => 'Password1234'
        ]);
        $collectionCode = <<<EOD
        \$collection = new Collection([
            'id' => 1,
            'username' => 'endriusolo',
            'password' => 'Password1234'
        ]);
        EOD;
        $this->showCode($collectionCode);

        $valuesCollection = $collection->values('id', 'username');
        $valuesCollectionCode = <<<EOD
        \$valuesCollection = \$collection->values('id', 'username');
        EOD;

        $this->showCode($valuesCollectionCode);
        var_dump($valuesCollection->get());
    }

    private function chunkTest(): void
    {
        $collection = new Collection([1, 2, 3, 4, 5, 6, 7, 8]);
        $this->showCode('$collection = new Collection([1, 2, 3, 4, 5, 6, 7, 8]);');

        $chunkCollection = $collection->chunk(3);

        $this->showCode('$chunkCollection = $collection->chunk(3);');
        var_dump($chunkCollection->get());
    }

    private function sliceTest(): void
    {
        $collection = new Collection([1, 2, 3, 4, 5, 6, 7]);
        $this->showCode('$collection = new Collection([1, 2, 3, 4, 5, 6, 7]);');

        $slicedCollectionNoLength = $collection->slice(3);
        $this->showCode('$slicedCollectionNoLength = $collection->slice(3);');
        var_dump($slicedCollectionNoLength);

        $slicedCollectionWithLength = $collection->slice(3, 2);
        $this->showCode('$slicedCollectionWithLength = $collection->slice(3, 2);');
        var_dump($slicedCollectionWithLength);
    }

    private function takeTest(): void
    {
        $collection = new Collection([1, 2, 3, 4, 5]);
        $this->showCode('$collection = new Collection([1, 2, 3, 4, 5]);');

        $takePositiveCollection = $collection->take(2);
        $this->showCode('$takePositiveCollection = $collection->take(2);');
        var_dump($takePositiveCollection->get());

        $takeNegatieCollection = $collection->take(-2);
        $this->showCode('$takeNegatieCollection = $collection->take(-2);');
        var_dump($takeNegatieCollection->get());
    }

    private function skipTest(): void
    {
        $collection = new Collection([1, 2, 3, 4]);
        $this->showCode('$collection = new Collection([1, 2, 3, 4]);');

        $skipCollection = $collection->skip(2);
        $this->showCode('$skipCollection = $collection->skip(2);');
        var_dump($skipCollection->get());
    }

    private function flipTest(): void
    {
        $collection = new Collection([
            'id' => 1,
            'username' => 'endriusolo'
        ]);
        $collectionCode = <<<EOD
        \$collection = new Collection([
            'id' => 1,
            'username' => 'endriusolo'
        ]);
        EOD;
        $this->showCode($collectionCode);

        $flipCollection = $collection->flip();
        $this->showCode('$flipCollection = $collection->flip();');
        var_dump($flipCollection->get());
    }

    private function shuffleTest(): void
    {
        $collection = new Collection([1, 2, 3, 4, 5]);
        $this->showCode('$collection = new Collection([1, 2, 3, 4, 5]);');

        $shuffleCollection = $collection->shuffle();
        $this->showCode('$shuffleCollection = $collection->shuffle();');
        var_dump($shuffleCollection->get());
    }

    private function groupTest(): void
    {
        echo 'Alias for chunk';
    }

    private function uniqueTest(): void
    {
        $collection = new Collection([1, 2, 2, 3, 4, 5]);
        $this->showCode('$collection = new Collection([1, 2, 2, 3, 4, 5]);');

        $uniqueCollection = $collection->unique();
        $this->showCode('$uniqueCollection = $collection->unique();');
        var_dump($uniqueCollection->get());
    }

    private function duplicateTest(): void
    {
        $collection = new Collection([1, 2, 2, 3, 4, 5]);
        $this->showCode('$collection = new Collection([1, 2, 2, 3, 4, 5]);');

        $duplicatesCollection = $collection->duplicates();
        $this->showCode('$duplicatesCollection = $collection->duplciates();');
        var_dump($duplicatesCollection->get());
    }

    private function sortByValuesAscTest(): void
    {
        $collection = new Collection([1, 4, 3, 5]);
        $this->showCode('$collection = new Collection([1, 4, 3, 5]);');

        $sortByValuesAscCollection = $collection->sortByValueAsc();
        $this->showCode('$sortByValuesAscCollection = $collection->sortByValueAsc();');
        var_dump($sortByValuesAscCollection->get());
    }

    private function sortByValuesDescTest(): void
    {
        $collection = new Collection([1, 4, 3, 5]);
        $this->showCode('$collection = new Collection([1, 4, 3, 5]);');

        $sortByValuesDescCollection = $collection->sortByValueDesc();
        $this->showCode('$sortByValuesDescCollection = $collection->sortByValueDesc();');
        var_dump($sortByValuesDescCollection->get());
    }

    private function sortByKeyAscTest(): void
    {
        $collection = new Collection([
            'a' => 3,
            'c' => 2,
            'b' => 1,
        ]);
        $collectionCode = <<<EOD
        \$collection = new Collection([
            'a' => 3,
            'c' => 2,
            'b' => 1,
        ]);
        EOD;
        $this->showCode($collectionCode);

        $sortByKeyAscCollection = $collection->sortByKeyAsc();
        $this->showCode('$sortByKeyAscCollection = $collection->sortByKeyAsc();');
        var_dump($sortByKeyAscCollection->get());
    }

    private function sortByKeyDescTest(): void
    {
        $collection = new Collection([
            'a' => 3,
            'c' => 2,
            'b' => 1,
        ]);
        $collectionCode = <<<EOD
        \$collection = new Collection([
            'a' => 3,
            'c' => 2,
            'b' => 1,
        ]);
        EOD;
        $this->showCode($collectionCode);

        $sortByKeyDescCollection = $collection->sortByKeyDesc();
        $this->showCode('$sortByKeyDescCollection = $collection->sortByKeyDesc();');
        var_dump($sortByKeyDescCollection->get());
    }

    private function addTest(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->showCode('$collection = new Collection([1, 2, 3]);');

        $collection->add(4, 5);
        $collection->add([8, 9]);

        $collectionAddCode = <<<EOD
        \$collection->add(4, 5);
        \$collection->add([8, 9]);
        EOD;
        $this->showCode($collectionAddCode);
        var_dump($collection->get());
    }

    private function unshiftTest(): void
    {
        $collection = new Collection([1, 2, 3]);
        $this->showCode('$collection = new Collection([1, 2, 3]);');

        $collection->unshift(4, 5);
        $collection->unshift([8, 9]);

        $collectionUnshiftCode = <<<EOD
        \$collection->unshift(4, 5);
        \$collection->unshift([8, 9]);
        EOD;
        $this->showCode($collectionUnshiftCode);
        var_dump($collection->get());
    }

    private function countTest(): void
    {
        $collection = new Collection([1, 2, 3, 4]);
        $this->showCode('$collection = new Collection([1, 2, 3, 4]);');

        $this->showCode($collection->count());
        var_dump($collection->count());
    }

    private function showCode(string $code)
    {
        echo '<pre>';
        echo $code;
        echo '</pre>';
    }
}
