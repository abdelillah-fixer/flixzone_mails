<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlane;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    //
    public function subscribe(Request $req)
    {

        //$userId, $subPlaneId
        if (empty($req->all())) {
            return response()->json(['message' => 'no data provided '], Response::HTTP_BAD_REQUEST);
        }

        $validator = Validator::make($req->all(), [
            'subPlaneId' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()], Response::HTTP_BAD_REQUEST); // You can customize the response as needed
        }
        $userId = Auth::id();
        $subPlaneId = $req->input('subPlaneId');

        if (!SubscriptionPlane::find($subPlaneId)) {
            return response()->json(["message" => "the subscription selected is unfound please try again later"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        //save subsciption
        $subscription = new Subscription();
        $subscription->user_id = $userId;
        $subscription->sub_plan_id = $subPlaneId;

        if (!$subscription->save()) {
            return response()->json(["message" => "something wrong happend saving your subscription please try again later"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(["message" => "subscription created succesfully", 'data' => $subscription], Response::HTTP_CREATED);
        $userEmail = Auth::user()->email;
        $userName = Auth::user()->firstName;
        Mail::to($userEmail)->send(new SubscriptionConfirmation());
  
        return response()->json(["message" => "subscription created successfully", 'data' => $subscription], Response::HTTP_CREATED);
    }

    public function unSubscribe($subscriptionId)
    {
        $subscriptionToDelete = Subscription::find($subscriptionId);

        if (!$subscriptionToDelete) {
            return response()->json(["message" => "no subscription was unfound with id " . $subscriptionId], Response::HTTP_NOT_FOUND);
        }

        if ($subscriptionToDelete->user_id != Auth::id()) {
            return response()->json(["message" => "something wrong happend please try again later"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (!$subscriptionToDelete->delete()) {
            return response()->json(["message" => "something wrong happend unsubscribing please try again later"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(["message" => "You've been unsubscribed succesfully", 'data' => $subscriptionToDelete], Response::HTTP_OK);
    }

    public function get($id = null)
    {
        //if user is admin we gonna return every subscription
        if (Auth::user()->is_admin) {
            if ($id) {


                $subscription = Subscription::find($id);
                if (!$subscription) {
                    return response()->json(["message" => "subscription was unfound with id " . $id], Response::HTTP_NOT_FOUND);
                }
                return response()->json(["data" => $subscription], Response::HTTP_OK);
            }


            $subscriptions = Subscription::all();
            if ($subscriptions->isEmpty()) {
                return response()->json(["message" => "no subscription found"], Response::HTTP_NOT_FOUND);
            }
            return response()->json(["data" => $subscriptions], Response::HTTP_OK);
        } elseif (Auth::user()->is_gym_owner) {
            // User is a gym owner, return subscriptions of their gyms
            $gymSubscriptions = Auth::user()->gyms->flatMap(function ($gym) {
                return $gym->subscriptions;
            });

            if ($gymSubscriptions->isEmpty()) {
                return response()->json(["message" => "No subscriptions found for the user's gyms"], Response::HTTP_NOT_FOUND);
            }

            // If $id is provided, filter the result to find the specific subscription
            if ($id) {
                $subscription = $gymSubscriptions->find($id);

                if (!$subscription) {
                    return response()->json(["message" => "Subscription not found with id " . $id], Response::HTTP_NOT_FOUND);
                }

                return response()->json(["data" => $subscription], Response::HTTP_OK);
            }

            return response()->json(["data" => $gymSubscriptions], Response::HTTP_OK);
        } else {
            //so the user is not an admin so we need to return just his subscription
            $userSubscriptions = Auth::user()->subscriptions;

            if ($userSubscriptions->isEmpty()) {
                return response()->json(["message" => "No subscriptions found for the user"], Response::HTTP_NOT_FOUND);
            }

            // If $id is provided, filter the result to find the specific subscription
            if ($id) {
                $subscription = $userSubscriptions->find($id);

                if (!$subscription) {
                    return response()->json(["message" => "Subscription not found with id " . $id], Response::HTTP_NOT_FOUND);
                }

                return response()->json(["data" => $subscription], Response::HTTP_OK);
            }

            return response()->json(["data" => $userSubscriptions], Response::HTTP_OK);
        }
    }
    private function activateSubscription()
    {
    }

    private function paySubscription()
    {
    }
      // Send confirmation email to the user
     
}
