<?php

namespace AmotiveTech\UnifiedSearch;

use AmotiveTech\UnifiedSearch\responseObjects\UsAutoInfoListResponse;
use AmotiveTech\UnifiedSearch\responseObjects\UsAutoInfoPageResponse;
use AmotiveTech\UnifiedSearch\responseObjects\UsAutoInfoResponse;
use AmotiveTech\UnifiedSearch\responseObjects\UsOemParamsResponse;
use AmotiveTech\UnifiedSearch\responseObjects\UsOffer;
use AmotiveTech\UnifiedSearch\responseObjects\UsOfferPageResponse;
use AmotiveTech\UnifiedSearch\responseObjects\UsSearchByOemsResponse;
use AmotiveTech\UnifiedSearch\responseObjects\UsSearchResultPageResponse;
use AmotiveTech\UnifiedSearch\responseObjects\UsStringsResponse;
use AmotiveTech\UnifiedSearch\responseObjects\UsTagsCountsResponse;
use AmotiveTech\UnifiedSearch\responseObjects\UsUser;
use AmotiveTech\UnifiedSearch\responseObjects\UsVehicleListResponse;
use AmotiveTech\UnifiedSearch\responseObjects\UsDetailResolveResponse;
use JetBrains\PhpStorm\Deprecated;

/**
 * Class UnifiedSearchService
 * @package AmotiveTech\UnifiedSearch
 * @deprecated Use laximoru/search package
 */
class USService extends Service
{
    /*****************************
     *  Part search
     *****************************/

    /**
     * Детектировать в запросе VIN/FRAME номера
     */
    public const ADVANCED_SEARCH_OPTION_DETECT_VEHICLE = 'detectVehicleIdentString';

    /**
     * Детектировать бренды деталей в запросе
     */
    public const ADVANCED_SEARCH_OPTION_DETECT_BRANDS = 'detectBrands';

    /**
     * Детектировать артикулы в запросе
     */
    public const ADVANCED_SEARCH_OPTION_DETECT_OEMS = 'detectOems';
    public const ADVANCED_SEARCH_OPTION_DETECT_CROSSBRANDS = 'searchCrossBrands';
    public const ADVANCED_SEARCH_OPTION_DETECT_CROSSOEMS = 'searchCrossOems';
    public const ADVANCED_SEARCH_OPTION_DETECT_CROSSPARTS = 'searchCrossDetails';
    public const ADVANCED_SEARCH_OPTION_DETECT_ORIGINALS = 'originals';

    public const ADVANCED_SEARCH_SEARCHBY_OFFER = 'OFFER';
    public const ADVANCED_SEARCH_SEARCHBY_OFFER_AND_DETAIL = 'OFFER_AND_DETAIL';
    public const ADVANCED_SEARCH_SEARCHBY_OFFER_AND_DETAIL_AND_CROSS = 'OFFER_AND_DETAIL_AND_CROSS';

    /**
     * @deprecated Use laximoru/search package
     */
    public function advancedSearch(
        string $query,
        ?int   $autoInfoId = null,
        array  $options = [],
        string $searchBy = self::ADVANCED_SEARCH_SEARCHBY_OFFER_AND_DETAIL,
        array  $tags = [],
        bool   $tagConcatenateByAnd = true,
        string $locale = 'ru_RU',
        int    $page = 0,
        int    $size = 20): UsSearchResultPageResponse
    {
        $params = [
            'autoInfoId' => $autoInfoId,
            'query' => $query,
            'detectVehicleIdentString' => in_array(self::ADVANCED_SEARCH_OPTION_DETECT_VEHICLE, $options) ? 'true' : 'false',
            'detectBrands' => in_array(self::ADVANCED_SEARCH_OPTION_DETECT_BRANDS, $options) ? 'true' : 'false',
            'detectOems' => in_array(self::ADVANCED_SEARCH_OPTION_DETECT_OEMS, $options) ? 'true' : 'false',
            'searchCrossBrands' => in_array(self::ADVANCED_SEARCH_OPTION_DETECT_CROSSBRANDS, $options) ? 'true' : 'false',
            'searchCrossOems' => in_array(self::ADVANCED_SEARCH_OPTION_DETECT_CROSSOEMS, $options) ? 'true' : 'false',
            'searchCrossDetails' => in_array(self::ADVANCED_SEARCH_OPTION_DETECT_CROSSPARTS, $options) ? 'true' : 'false',
            'searchBy' => $searchBy,
            'tags' => $tags,
            'tagsLogicOperation' => $tagConcatenateByAnd ? 'AND' : 'OR',
            'originals' => in_array(self::ADVANCED_SEARCH_OPTION_DETECT_ORIGINALS, $options) ? 'true' : 'false',
            'locale' => $locale,
        ];

        return $this->makeRequest(UsSearchResultPageResponse::class, 'POST', 'search', 'advancedSearch', [
            'page' => $page,
            'size' => $size,
        ], $params);
    }

    /**
     * @deprecated Use laximoru/search package
     */
    public function search(string $query, ?int $autoInfoId = null, array $tags = [], string $locale = 'ru_RU', int $page = 0, int $size = 20): UsSearchResultPageResponse
    {
        return $this->makeRequest(UsSearchResultPageResponse::class, 'GET', 'search', 'search', [
            'autoInfoId' => $autoInfoId,
            'query' => $query,
            'tags' => implode('&', $tags),
            'locale' => $locale,
            'page' => $page,
            'size' => $size,
        ]);
    }

    /**
     * @deprecated Use laximoru/search package
     */
    public function searchByOems(int $autoInfoId, array $oems, string $locale = 'ru_RU'): UsSearchByOemsResponse
    {
        return $this->makeRequest(UsSearchByOemsResponse::class, 'GET', 'search', 'searchByOems', [
            'autoInfoId' => $autoInfoId,
            'oems' => $oems,
            'locale' => $locale,
        ]);
    }

    /**
     * @deprecated Use laximoru/search package
     */
    public function countByTags(int $autoInfoId): UsTagsCountsResponse
    {
        return $this->makeRequest(UsTagsCountsResponse::class, 'GET', 'search', 'countByTags', [
            'autoInfoId' => $autoInfoId,
        ]);
    }

    /**
     * @deprecated Use laximoru/search package
     */
    public function complete(string $query): UsStringsResponse
    {
        return $this->makeRequest(UsStringsResponse::class, 'GET', 'search', 'complete', [
            'query' => $query,
        ]);
    }

    /*****************************
     *  Offers portfolio
     *****************************/

    public const CHARSET_UTF8 = 'UTF-8';
    public const CHARSET_WINDOWS1251 = 'windows-1251';
    public const CHARSET_UTF16BE = 'UTF-16BE';
    public const CHARSET_UTF16LE = 'UTF-16LE';

    public const DELIMITER_TAB = "\t";
    public const DELIMITER_COMMA = ",";
    public const DELIMITER_SEMICOLON = ";";

    /**
     * @deprecated Use laximoru/search package
     */
    public function offersProcess(string $tmpFileName, string $userFileName, ?string $delimiter = null, ?string $charsetName = null): UsOffer
    {
        $params = [];

        if ($delimiter) {
            $params['delimiter'] = $delimiter;
        }

        if ($charsetName) {
            $params['charsetName'] = $charsetName;
        }

        return $this->makeRequest(UsOffer::class, 'POST', 'offer', 'process', $params, null, $tmpFileName, $userFileName);
    }

    /**
     * @deprecated Use laximoru/search package
     */
    public function offersList(int $page = 0, int $size = 20): UsOfferPageResponse
    {
        return $this->makeRequest(UsOfferPageResponse::class, 'GET', 'offer', 'list', [
            'page' => $page,
            'size' => $size,
        ]);
    }

    /**
     * @deprecated Use laximoru/search package
     */
    public function offersGet(int $offerId): UsOffer
    {
        return $this->makeRequest(UsOffer::class, 'GET', 'offer', 'get', ['offerId' => $offerId]);
    }

    /**
     * @deprecated Use laximoru/search package
     */
    public function offersSource(int $offerId): string
    {
        return $this->makeRequest(null, 'GET', 'offer', 'source', ['offerId' => $offerId]);
    }

    /**
     * @deprecated Use laximoru/search package
     */
    public function offersErrors(int $offerId): string
    {
        return $this->makeRequest(null, 'GET', 'offer', 'errors', ['offerId' => $offerId]);
    }

    /**
     * @deprecated Use laximoru/search package
     */
    public function offersListTags(int $offerId): UsStringsResponse
    {
        return $this->makeRequest(UsStringsResponse::class, 'GET', 'offer', 'listTags', ['offerId' => $offerId]);
    }

    /*****************************
     *  Vehicle identification
     *****************************/

    /**
     * @deprecated Use laximoru/search package
     */
    public function vehicleIdentify(string $identString, string $locale = 'ru_RU'): UsVehicleListResponse
    {
        return $this->makeRequest(UsVehicleListResponse::class, 'GET', 'vehicle', 'identify', [
            'identString' => $identString,
            'locale' => $locale,
        ]);
    }

    /**
     * @deprecated Use laximoru/search package
     */
    public function vehicleIdentifyBySsd(string $catalog, string $vehicleId, string $ssd, string $locale = 'ru_RU'): UsVehicleListResponse
    {
        return $this->makeRequest(UsVehicleListResponse::class, 'GET', 'vehicle', 'identifyBySsd', [
            'catalog' => $catalog,
            'vehicleId' => $vehicleId,
            'ssd' => $ssd,
            'locale' => $locale,
        ]);
    }

    /*****************************
     *  User info
     *****************************/

    /**
     * @deprecated Use laximoru/search package
     */
    public function user(): UsUser
    {
        return $this->makeRequest(UsUser::class, 'GET', 'currentUser');
    }

    /*****************************
     *  Vehicle indexation
     *****************************/

    /**
     * @deprecated Use laximoru/search package
     */
    public function indexationListAutoInfo(int $page = 0, int $size = 20): UsAutoInfoPageResponse
    {
        return $this->makeRequest(UsAutoInfoPageResponse::class, 'GET', 'autoInfo', 'listAutoInfo', [
            'page' => $page,
            'size' => $size,
        ]);
    }

    /**
     * @deprecated Use laximoru/search package
     */
    public function indexationIndexVehicle(int $autoInfoId): UsAutoInfoResponse
    {
        return $this->makeRequest(UsAutoInfoResponse::class, 'GET', 'autoInfo', 'indexVehicle', [
            'autoInfoId' => $autoInfoId,
        ]);
    }

    /**
     * @deprecated Use laximoru/search package
     */
    public function indexationGetAutoInfo(int $autoInfoId): UsAutoInfoResponse
    {
        return $this->makeRequest(UsAutoInfoResponse::class, 'GET', 'autoInfo', 'getAutoInfo', [
            'autoInfoId' => $autoInfoId,
        ]);
    }

    /**
     * @deprecated Use laximoru/search package
     */
    public function indexationFindByIdentString(string $identString): UsAutoInfoListResponse
    {
        return $this->makeRequest(UsAutoInfoListResponse::class, 'GET', 'autoInfo', 'findByIdentString', [
            'identString' => $identString,
        ]);
    }

    /**
     * @deprecated Use laximoru/search package
     */
    public function resolveDetailIdsToOemsForAutoInfo(int $autoInfoId, array $detailId): UsDetailResolveResponse
    {
        return $this->makeRequest(UsDetailResolveResponse::class, 'GET', 'search', 'resolveDetailIdsToOemsForAutoInfo', [
            'autoInfoId' => $autoInfoId,
            'detailId' => $detailId,
        ]);
    }

    /**
     * @deprecated Use laximoru/search package
     */
    public function getParamsForOemService(int $autoInfoId): UsOemParamsResponse
    {
        return $this->makeRequest(UsOemParamsResponse::class, 'GET', 'autoInfo', 'getParamsForOemService', [
            'autoInfoId' => $autoInfoId,
        ]);
    }

}
