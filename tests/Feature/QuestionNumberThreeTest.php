<?php



// Ensure the GeoIpMiddleware class exists in the App\Http\Middleware namespace
// If it does not exist, create the class in the appropriate directory.
use App\Services\GeoIP;
use App\Http\Middleware\GeoIpMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

test('GeoIpMiddleware sets geo-IP data in the service container', function () {
    // Mock the GeoIP::lookup method
    $mockGeoIpData = [
        'latitude' => 51.509865,
        'longitude' => -0.118092,
    ];
    $geoIpMock = Mockery::mock(GeoIP::class);
    $geoIpMock->shouldReceive('lookup')
        ->once()
        ->with('127.0.0.1')
        ->andReturn($mockGeoIpData);

    // Create a request with a fake IP address
    $request = Request::create('/', 'GET');
    $request->server->set('REMOTE_ADDR', '127.0.0.1');

    // Create an instance of the middleware
    $middleware = new GeoIpMiddleware($geoIpMock);

    // Handle the request
    $response = $middleware->handle($request, function ($req) {
        return response('OK');
    });

    // Assert that the geo-IP data is set in the service container
    expect(app('geoIpData'))->toBe($mockGeoIpData);
});

test('GeoIpMiddleware uses cached data for the same IP address', function () {
    // Mock the GeoIP::lookup method
    $mockGeoIpData = [
        'latitude' => 51.509865,
        'longitude' => -0.118092,
    ];
    $geoIpMock = Mockery::mock(GeoIP::class);
    $geoIpMock->shouldReceive('lookup')
        ->once()
        ->with('127.0.0.1')
        ->andReturn($mockGeoIpData);

    // Create a request with a fake IP address
    $request = Request::create('/', 'GET');
    $request->server->set('REMOTE_ADDR', '127.0.0.1');

    // Create an instance of the middleware
    $middleware = new GeoIpMiddleware($geoIpMock);

    // Handle the request twice (should use cache the second time)
    $middleware->handle($request, function ($req) {
        return response('OK');
    });

    // Clear the mock to ensure the lookup is not called again
    $geoIpMock->shouldReceive('lookup')->never();

    // Handle the request again
    $middleware->handle($request, function ($req) {
        return response('OK');
    });

    // Assert that the geo-IP data is set in the service container
    expect(app('geoIpData'))->toBe($mockGeoIpData);
});

test('GeoIpMiddleware provides fallback data when lookup fails', function () {
    // Mock the GeoIP::lookup method to return null
    $geoIpMock = Mockery::mock(GeoIP::class);
    $geoIpMock->shouldReceive('lookup')
        ->once()
        ->with('127.0.0.1')
        ->andReturn(null);

    // Create a request with a fake IP address
    $request = Request::create('/', 'GET');
    $request->server->set('REMOTE_ADDR', '127.0.0.1');

    // Create an instance of the middleware
    $middleware = new GeoIpMiddleware($geoIpMock);

    // Handle the request
    $response = $middleware->handle($request, function ($req) {
        return response('OK');
    });

    // Assert that the fallback data is set in the service container
    expect(app('geoIpData'))->toBe([
        'latitude' => 0,
        'longitude' => 0,
    ]);
});

