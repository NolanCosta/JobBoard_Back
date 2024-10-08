<!-- Step 01 -->

Mise en place de la BDD avec les migrations.

Modification de la table users pour y ajouter : Lastname - firstname - phone - address - zip_code - city - role

Creation de la table companies avec : name - logo - address - zip_code - city - aboutUs - user_id (clé étrangère relié à la table users)

ajout de la clé étrangère company_id à la table users

Creation de la table advertisements avec : title - type - sector - description - tags - zip_code - city - status - company_id (clé étrangère relié à la table companies)

Creation de la table follow_advertisements avec : email_sent - status - user_id (clé étrangère relié à la table users) - advertisement_id (clé étrangère relié à la table advertisements)
