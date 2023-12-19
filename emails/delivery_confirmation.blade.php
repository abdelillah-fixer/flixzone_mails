@component('mail::message')
# Delivery Confirmation

Merci d'avoir soumis vos informations de livraison. Voici les détails:

- **Nom et prénom:** {{ $formData['name'] }}
- **Numéro de téléphone:** {{ $formData['phone'] }}
- **Adresse:** {{ $formData['address'] }}
- **Ville:** {{ $formData['city'] }}
- **Pays:** {{ $formData['country'] }}
- **Code postal:** {{ $formData['zip'] }}
- **La date de livraison:** {{ $formData['delivery_date'] }}

Nous traiterons votre demande de livraison dans les plus brefs délais.

Merci,<br>
Flixzone
@endcomponent