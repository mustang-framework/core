<?php

namespace Mustang\Core\Loaders;

use Mustang\Core\Foundation\Facades\Mustang;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Finder\SplFileInfo;

trait RoutesLoaderTrait
{
    /**
     * Register all the containers routes files in the framework
     */
    public function runRoutesAutoLoader(): void
    {
        $containersPaths = Mustang::getAllContainerPaths();

        foreach ($containersPaths as $containerPath) {
            $this->loadApiContainerRoutes($containerPath);
            $this->loadWebContainerRoutes($containerPath);
        }
    }

    /**
     * Register the Containers API routes files
     * @param string $containerPath
     */
    private function loadApiContainerRoutes(string $containerPath): void
    {
        // Build the container api routes path
        $apiRoutesPath = $containerPath . '/UI/API/Routes';
        // Build the namespace from the path
        $controllerNamespace = $containerPath . '\\UI\API\Controllers';

        if (File::isDirectory($apiRoutesPath)) {
            $files = File::allFiles($apiRoutesPath);
            $files = Arr::sort($files, function ($file) {
                return $file->getFilename();
            });
            foreach ($files as $file) {
                $this->loadApiRoute($file, $controllerNamespace);
            }
        }
    }

    /**
     * @param $file
     * @param $controllerNamespace
     */
    private function loadApiRoute($file, $controllerNamespace): void
    {
        $routeGroupArray = $this->getRouteGroup($file, $controllerNamespace);

        Route::group($routeGroupArray, function ($router) use ($file) {
            require $file->getPathname();
        });
    }

    /**
     * @param      $endpointFileOrPrefixString
     * @param null $controllerNamespace
     *
     * @return  array
     */
    public function getRouteGroup($endpointFileOrPrefixString, $controllerNamespace = null): array
    {
        return [
            'namespace' => $controllerNamespace,
            'middleware' => $this->getMiddlewares(),
            'domain' => $this->getApiUrl(),
            // If $endpointFileOrPrefixString is a file then get the version name from the file name, else if string use that string as prefix
            'prefix' => is_string($endpointFileOrPrefixString) ? $endpointFileOrPrefixString : $this->getApiVersionPrefix($endpointFileOrPrefixString),
        ];
    }

    /**
     * @return  array
     */
    private function getMiddlewares(): array
    {
        return array_filter([
            'api',
            $this->getRateLimitMiddleware(), // Returns NULL if feature disabled. Null will be removed form the array.
        ]);
    }

    /**
     * @return  null|string
     */
    private function getRateLimitMiddleware(): ?string
    {
        $rateLimitMiddleware = null;

        if (Config::get('mustang.api.throttle.enabled')) {
            RateLimiter::for('api', function (Request $request) {
                return Limit::perMinutes(Config::get('mustang.api.throttle.expires'), Config::get('mustang.api.throttle.attempts'))->by($request->user()?->id ?: $request->ip());
            });

            $rateLimitMiddleware = 'throttle:api';
        }

        return $rateLimitMiddleware;
    }

    /**
     * @return  mixed
     */
    private function getApiUrl()
    {
        return Config::get('mustang.api.url');
    }

    /**
     * @param $file
     *
     * @return  string
     */
    private function getApiVersionPrefix($file): string
    {
        return Config::get('mustang.api.prefix') . (Config::get('mustang.api.enable_version_prefix') ? $this->getRouteFileVersionFromFileName($file) : '');
    }

    /**
     * @param $file
     *
     * @return  string|bool
     */
    private function getRouteFileVersionFromFileName($file): string|bool
    {
        $fileNameWithoutExtension = $this->getRouteFileNameWithoutExtension($file);

        $fileNameWithoutExtensionExploded = explode('.', $fileNameWithoutExtension);

        end($fileNameWithoutExtensionExploded);

        $apiVersion = prev($fileNameWithoutExtensionExploded); // get the array before the last one

        // Skip versioning the API's root route
        if ($apiVersion === 'ApisRoot') {
            $apiVersion = '';
        }

        return $apiVersion;
    }

    /**
     * @param SplFileInfo $file
     *
     * @return  mixed
     */
    private function getRouteFileNameWithoutExtension(SplFileInfo $file): mixed
    {
        return pathinfo($file->getFileName())['filename'];
    }

    /**
     * Register the Containers WEB routes files
     *
     * @param $containerPath
     */
    private function loadWebContainerRoutes($containerPath): void
    {
        // build the container web routes path
        $webRoutesPath = $containerPath . '/UI/WEB/Routes';
        // build the namespace from the path
        $controllerNamespace = $containerPath . '\\UI\WEB\Controllers';

        if (File::isDirectory($webRoutesPath)) {
            $files = File::allFiles($webRoutesPath);
            $files = Arr::sort($files, function ($file) {
                return $file->getFilename();
            });
            foreach ($files as $file) {
                $this->loadWebRoute($file, $controllerNamespace);
            }
        }
    }

    /**
     * @param $file
     * @param $controllerNamespace
     */
    private function loadWebRoute($file, $controllerNamespace): void
    {
        Route::group([
            'namespace' => $controllerNamespace,
            'middleware' => ['web'],
        ], function ($router) use ($file) {
            require $file->getPathname();
        });
    }
}
