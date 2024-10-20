<!-- Initialisation du projet -->

commande a effectuer dans le terminal :

-   composer install (installation des dépendances liées au projet)

-   Mise en place du .env (remplacer les données par celle de votre environnement):

    Pour la base de données :

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=jobsboard
    DB_USERNAME=root
    DB_PASSWORD=

    Pour la gestion des mails :

    MAIL_MAILER=smtp
    MAIL_HOST=sandbox.smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME="USERNAME"
    MAIL_PASSWORD="PASSWORD
    MAIL_ENCRYPTION=tls
    MAIL_FROM_ADDRESS="adresse@example.com"
    MAIL_FROM_NAME="${APP_NAME}"

-   php artisan migrate --seed (initilisation de la base de données et des données tests)

-   php artisan serve (lancement du serveur)

<!-- Méthode MCV de Laravel (Model, View, Controller -->

<!-- Models -->

Les modèles dans Laravel représentent les tables de la base de données et facilitent les opérations CRUD grâce à l'ORM Eloquent (le système de gestion des bases de données intégré à Laravel). Ils permettent de valider les données, de définir des relations entre entités, et d'utiliser des accesseurs et mutateurs pour manipuler les attributs. En simplifiant les requêtes et en intégrant des scopes, les modèles offrent une abstraction puissante pour gérer les données tout en améliorant la lisibilité et la maintenance du code.

Chaque Model à une base commune :

Namespace : Cela indique qu'une classe fait partie du namespace App\Models, ce qui aide à organiser le code et à éviter les conflits de noms.

Utilisation des Traits : Ici, les modèles utilisent le trait HasFactory, ce qui permet de générer des usines (factories) pour créer facilement des instances de ce modèle lors des tests ou du remplissage de la base de données. Pour le modèle "User", on retrouve d'autre traits tel que, Authenticatable (Permet d'implémenter les fonctionnalités d'authentification), Notifiable (Permet d'envoyer des notifications à l'utilisateur) et HasApiTokens (Permet de générer des tokens API pour l'utilisateur).

Déclaration de la classe : Les différentes classes héritent de la classe Model d'Eloquent. Cela signifie qu'elles ont accès à toutes les fonctionnalités d'Eloquent pour interagir avec la base de données.

Propriétés de la classe : - La propriété $fillable est un tableau qui définit les attributs qui peuvent être assignés. Cela signifie que lorsque tu crées ou mets à jour un modèle, seuls ces attributs peuvent être assignés via des tableaux ou des objets. - la propriété $hidden dans le Model "User" définit les attributs qui ne doivent pas être affichés lors de la sérialisation du modèle, comme le mot de passe et le remember_token.

Méthode de relation : - Dans le Model "Advertisement", la function company() définit une relation entre le modèle Advertisement et un autre modèle appelé Company. La méthode belongsTo indique que chaque annonce appartient à une seule entreprise. Cela signifie que chaque enregistrement d'annonce a un champ company_id qui référence l'ID de l'entreprise associée. - Dans le Model "User", la function casts() définit comment certains attributs doivent être castés (transformés) lors de leur utilisation. Par exemple, email_verified_at sera traité comme un objet datetime, et le mot de passe sera automatiquement haché.

<!-- Views -->

Du côté de Back-end, il y a seulement le fichier name.blade.php qui correspond au message envoyer dans le mail lors du candidature envoyée. Pour le reste, les views sont réalisées avec ReactJS.

<!-- Controllers -->

UserController :

1. index()

    Fonction : Récupère tous les utilisateurs de la base de données.
    Retourne : Un JSON contenant la liste des utilisateurs avec un code de statut 200.

2. store(Request $request)

    Fonction : Crée un nouvel utilisateur.
    Validation : Vérifie que les champs requis (prénom, nom, email, téléphone, mot de passe) sont présents et valides. L'email doit être unique.
    Création : Si la validation réussit, l'utilisateur est créé et le mot de passe est haché avec bcrypt.
    Retourne : Un message de succès ou une erreur en cas d'exception.

3. auth(Request $request)

    Fonction : Authentifie un utilisateur.
    Validation : Vérifie que l'email et le mot de passe sont fournis.
    Vérification : Cherche l'utilisateur par email et vérifie le mot de passe.
    Retourne : Un message de succès avec les informations de l'utilisateur et un token d'authentification si la connexion réussit, ou une erreur si l'authentification échoue.

4. logout(Request $request)

    Fonction : Déconnecte l'utilisateur en supprimant le token d'accès actuel.
    Retourne : Un message de succès ou une erreur en cas d'exception.

5. update(Request $request, $id)

    Fonction : Met à jour les informations d'un utilisateur existant.
    Validation : Vérifie les données à mettre à jour, tout en s'assurant que l'email est unique (en ignorant l'utilisateur actuel).
    Mise à jour : Met à jour les informations de l'utilisateur avec les nouvelles valeurs fournies ou laisse les anciennes si elles ne sont pas spécifiées.
    Retourne : Un message de succès avec les données mises à jour, ou une erreur si l'utilisateur n'est pas trouvé ou si la validation échoue.

6. destroy($id)

    Fonction : Supprime un utilisateur par son ID.
    Vérification : Cherche l'utilisateur. S'il n'est pas trouvé, retourne une erreur.
    Suppression : Si l'utilisateur est trouvé, il est supprimé.
    Retourne : Un message de succès ou une erreur si l'utilisateur n'est pas trouvé.

CompanyController :

1. index()

    Fonction : Récupère toutes les entreprises de la base de données.
    Retourne : Une réponse JSON contenant toutes les entreprises, avec un code de statut 200.

2. store(Request $request)

    Fonction : Crée une nouvelle entreprise ou permet à un utilisateur de rejoindre une entreprise existante.
    Validation :
    Si type est true, il valide les champs requis pour créer une nouvelle entreprise (nom, adresse, code postal, ville, description).
    Si type n'est pas true, il valide la présence de company_id pour rejoindre une entreprise existante.
    Création d'entreprise : Si l'entreprise n'existe pas déjà, elle est créée et l'utilisateur est associé à celle-ci.
    Rejoindre une entreprise : Si l'utilisateur rejoint une entreprise existante, il vérifie s'il ne fait pas déjà partie des collaborateurs. Si ce n'est pas le cas, il l'ajoute à la liste des collaborateurs.
    Retourne : Un message de succès ou une erreur appropriée.

3. show($id)

    Fonction : Récupère les détails d'une entreprise par son ID.
    Retourne : Les informations de l'entreprise sous forme de JSON, ou un message d'erreur si l'entreprise n'est pas trouvée.

4. update(Request $request, $id)

    Fonction : Met à jour les informations d'une entreprise existante.
    Validation : Vérifie que tous les champs requis sont présents.
    Mise à jour : Met à jour les informations de l'entreprise avec les nouvelles valeurs fournies.
    Retourne : Un message de succès ou une erreur si l'entreprise n'est pas trouvée ou si la validation échoue.

5. destroy($id)

    Fonction : Supprime une entreprise par son ID.
    Vérification : Cherche l'entreprise. Si elle n'est pas trouvée, retourne une erreur.
    Suppression : Si l'entreprise est trouvée, elle est supprimée de la base de données.
    Retourne : Un message de succès ou une erreur si l'entreprise n'est pas trouvée.

AdvertisementController :

1. index()

    Fonction : Récupère toutes les annonces d'emploi de la base de données.
    Retourne : Une réponse contenant toutes les annonces.

2. store(Request $request)

    Fonction : Crée une nouvelle annonce d'emploi.
    Validation : Utilise le validateur pour s'assurer que tous les champs requis sont présents et valides, y compris le nom de l'entreprise (company_id doit exister dans la table companies).
    Création : Si la validation réussit, une nouvelle annonce est créée dans la base de données.
    Retourne : Un message de succès avec les détails de l'annonce créée et un code de statut 201.

3. show($id)

    Fonction : Récupère les détails d'une annonce spécifique par son ID.
    Vérification : Cherche l'annonce dans la base de données. Si elle n'est pas trouvée, retourne un message d'erreur.
    Retourne : Les informations de l'annonce sous forme de JSON, ou un message d'erreur si l'annonce n'est pas trouvée.

4. update(Request $request, $id)

    Fonction : Met à jour une annonce existante.
    Vérification : Cherche l'annonce par ID. Si elle n'est pas trouvée, retourne une erreur.
    Validation : Valide les données fournies pour s'assurer qu'elles respectent les contraintes définies.
    Mise à jour : Met à jour les informations de l'annonce avec les nouvelles valeurs ou conserve les anciennes valeurs si aucune nouvelle valeur n'est fournie.
    Retourne : Un message de succès avec les détails de l'annonce mise à jour, ou une erreur si l'annonce n'est pas trouvée ou si la validation échoue.

5. destroy($id)

    Fonction : Supprime une annonce par son ID.
    Vérification : Cherche l'annonce dans la base de données. Si elle n'est pas trouvée, retourne une erreur.
    Suppression : Si l'annonce est trouvée, elle est supprimée de la base de données.
    Retourne : Un message de succès ou une erreur si l'annonce n'est pas trouvée.

FollowAdvertisementController :

1. index()

    Fonction : Récupère toutes les candidatures d'annonces d'emploi.
    Retourne : Toutes les candidatures sous forme de JSON.

2. store(Request $request)

    Fonction : Crée une nouvelle candidature pour une annonce d'emploi.
    Validation : Vérifie que tous les champs requis sont présents (nom, prénom, email, téléphone, message, et ID de l'annonce).
    Vérifications :
    Si l'annonce existe.
    Si l'utilisateur qui postule n'est pas le propriétaire de l'annonce.
    Création : Si tout est valide, la candidature est créée dans la base de données.
    Envoi d'email : Envoie un email au candidat pour confirmer que sa candidature a été envoyée.
    Retourne : Un message de succès ou une erreur en cas de problème lors de la validation ou de l'envoi de l'email.

3. update(Request $request, $id)

    Fonction : Met à jour une candidature existante.
    Vérification : Vérifie si la candidature existe. Si ce n’est pas le cas, retourne une erreur.
    Validation : Vérifie les champs requis pour la mise à jour.
    Mise à jour : Met à jour les informations de la candidature.
    Envoi d'email : Envoie un email au candidat pour confirmer que sa candidature a été mise à jour.
    Retourne : Un message de succès ou une erreur en cas de problème.

4. destroy($id)

    Fonction : Supprime une candidature par son ID.
    Vérification : Cherche la candidature. Si elle n'est pas trouvée, retourne une erreur.
    Suppression : Si la candidature est trouvée, elle est supprimée de la base de données.
    Retourne : Un message de succès ou une erreur si la candidature n'est pas trouvée.

<!-- Base de données -->

<!-- Migrations -->

Les migrations dans Laravel permettent de gérer la structure de la base de données de manière versionnée. Elles sont particulièrement utiles pour créer, modifier ou supprimer des tables et des colonnes.

Généralités sur les différentes Tables :

1. Namespaces et Utilisations :

    Migration : Classe de base pour les migrations.
    Blueprint : Permet de définir la structure des tables.
    Schema : Fournit des méthodes pour créer et manipuler des tables.

2. Classe Anonyme

    Cette syntaxe définit une classe anonyme qui étend la classe Migration. C'est une façon moderne d'écrire des migrations en PHP.

3. Méthode up

    Cette méthode est exécutée lors de l'application de la migration, c'est-à-dire lorsqu'on exécute la commande migrate.

4. Méthode down

    Cette méthode est exécutée lors du retour en arrière d'une migration (migrate:rollback). Elle supprime les tables créées dans la méthode up.

Table users :

    - Table "users"

    id() : Crée une colonne d'identifiant auto-incrémenté.
    string() : Définit des colonnes pour le prénom, nom, email, téléphone, adresse, etc.
    unique() : Assure que les valeurs dans les colonnes email et phone sont uniques.
    timestamp('email_verified_at')->nullable() : Colonne pour enregistrer la date de vérification de l'email, pouvant être nulle.
    enum('role', [...]) : Définit une colonne avec des valeurs spécifiques pour les rôles d'utilisateur.
    rememberToken() : Colonne pour stocker le token de session persistante.
    timestamps() : Ajoute les colonnes created_at et updated_at.

    - Table "password_reset_tokens" (automatiquement généré lors de l'initialisation de Laravel)

    Crée une table pour stocker les tokens de réinitialisation de mot de passe.
    primary() sur email : Définit l'email comme clé primaire.

    - Table "sessions"

    Crée une table pour stocker les sessions des utilisateurs.
    foreignId('user_id') : Référence à l'identifiant de l'utilisateur.
    longText('payload') : Stocke les données de la session.

Table companies :

    - Table "companies"

    id() : Crée une colonne d'identifiant auto-incrémenté pour les entreprises.
    string('name') : Colonne pour le nom de l'entreprise.
    string('logo')->nullable() : Colonne pour le logo, qui peut être nulle.
    string('address'), string('zip_code'), string('city') : Colonnes pour les informations d'adresse.
    text('aboutUs') : Colonne pour une description de l'entreprise.
    json('collaborators')->nullable() : Colonne pour stocker des données JSON sur les collaborateurs, pouvant être nulle.
    foreignId('user_id') : Référence à l'identifiant d'un utilisateur. Cela établit une relation entre la table companies et la table users.
        constrained() : Indique que cette colonne est une clé étrangère.
        nullOnDelete() : Si un utilisateur est supprimé, la valeur de user_id sera mise à null dans la table companies.
    timestamps() : Ajoute les colonnes created_at et updated_at.

    - Modification de la Table "users"

    Cette partie ajoute une colonne company_id à la table users, qui référence la table companies.
    Cela permet de lier un utilisateur à une entreprise.
    Comme pour user_id, company_id peut être nul et la contrainte de suppression est également appliquée.

Table advertisements :

    - Table "advertisements"

    id() : Crée une colonne d'identifiant auto-incrémenté pour chaque annonce.
    string('title') : Colonne pour le titre de l'annonce.
    enum('type', [...]) : Colonne pour le type de contrat, avec des valeurs prédéfinies (CDI, CDD, etc.).
    string('sector') : Colonne pour le secteur d'activité de l'annonce.
    text('description') : Colonne pour la description détaillée de l'annonce.
    string('wage')->nullable() : Colonne pour le salaire, qui peut être nulle.
    string('working_time')->nullable() : Colonne pour le temps de travail, qui peut également être nulle.
    json('skills')->nullable() : Colonne pour stocker des compétences requises sous forme de données JSON, qui peut être nulle.
    json('tags')->nullable() : Colonne pour des mots-clés sous forme de données JSON, qui peut être nulle.
    string('zip_code') : Colonne pour le code postal.
    string('city') : Colonne pour la ville où se trouve l'emploi.
    enum('status', [...]) : Colonne pour le statut de l'annonce, avec des valeurs possibles (PUBLISHED, STANDBY, ARCHIVED). Par défaut, le statut est PUBLISHED.
    foreignId('company_id') : Référence à la table companies via company_id, indiquant à quelle entreprise l'annonce appartient.
        constrained() : Indique que cette colonne est une clé étrangère.
        onDelete('cascade') : Si une entreprise est supprimée, toutes les annonces associées seront également supprimées.

    timestamps () : Ajoute les colonnes created_at et updated_at pour suivre la création et la mise à jour de chaque annonce.

Table follow_advertisements :

    - Table "follow_advertisements" :

    id() : Crée une colonne d'identifiant auto-incrémenté pour chaque enregistrement.
    text('email_sent') : Colonne pour stocker l'état de l'email envoyé (sous forme de texte).
    string('lastname') : Colonne pour le nom de famille de l'utilisateur.
    string('firstname') : Colonne pour le prénom de l'utilisateur.
    string('email') : Colonne pour l'adresse email de l'utilisateur.
    string('phone') : Colonne pour le numéro de téléphone de l'utilisateur.
    text('message') : Colonne pour stocker un message de l'utilisateur, probablement concernant l'annonce.
    enum('status', [...]) : Colonne pour le statut de l'interaction, avec des valeurs possibles : SENT, ACCEPTED, et REFUSED. Le statut par défaut est SENT.
    foreignId('user_id') : Référence à l'identifiant de l'utilisateur qui a suivi l'annonce.
        nullable() : La valeur peut être nulle, ce qui signifie que l'enregistrement peut exister sans être lié à un utilisateur spécifique.
        onDelete('cascade') : Si l'utilisateur est supprimé, les enregistrements associés dans cette table seront également supprimés.
    foreignId('advertisement_id') : Référence à l'identifiant de l'annonce suivie.
        constrained() : Indique que cette colonne est une clé étrangère liée à la table advertisements.
        onDelete('cascade') : Si l'annonce est supprimée, les enregistrements associés dans cette table seront également supprimés.
    timestamps() : Ajoute les colonnes created_at et updated_at pour suivre la création et la mise à jour des enregistrements.

<!-- Routes -->

User Registration and Login:
POST user/register: Permet à un nouvel utilisateur de s'inscrire en envoyant ses informations (comme l'email et le mot de passe).
POST user/login: Permet à un utilisateur existant de se connecter en validant ses identifiants.

Company Routes:
GET company: Récupère une liste de toutes les entreprises.
GET company/{id}: Récupère les détails d'une entreprise spécifique par son ID.

Advertisement Routes:
GET advertisement: Récupère une liste de toutes les publicités.
GET advertisement/{id}: Récupère les détails d'une publicité spécifique par son ID.
POST advertisement/create: Permet de créer une nouvelle publicité.
PUT advertisement/update/{id}: Permet de mettre à jour une publicité existante.
DELETE advertisement/delete/{id}: Permet de supprimer une publicité par son ID.

Follow Advertisement Routes:
POST followAdvertisement/create: Permet à un utilisateur de suivre une publicité spécifique.
GET followAdvertisement: Récupère toutes les publicités suivies par l'utilisateur.
PUT followAdvertisement/update/{id}: Permet de mettre à jour les informations d'une publicité suivie.
DELETE followAdvertisement/delete/{id}: Permet de se désabonner d'une publicité suivie.

User Administration Routes:
GET userAdmin: Récupère la liste de tous les utilisateurs pour la gestion administrative.
POST user/create: Permet de créer un nouvel utilisateur.
PUT user/update/{id}: Permet de mettre à jour les informations d'un utilisateur existant.
DELETE user/delete/{id}: Permet de supprimer un utilisateur par son ID.

<!-- Middleware -->

auth : Ce middleware protège les routes situées dans le groupe qui lui est associé. Cela signifie que seules les requêtes authentifiées (celles ayant un token d'authentification valide) peuvent accéder à ces routes. Lorsqu'un utilisateur se connecte, un token est généré. Il doit être inclus dans l'en-tête des requêtes pour accéder aux routes sécurisées. Cela permet de s'assurer que seules les actions autorisées peuvent être exécutées par des utilisateurs authentifiés, comme la création, la mise à jour ou la suppression d'objets (utilisateurs, entreprises, publicités, etc.).

<!-- .env -->

Le fichier .env dans un projet Laravel est utilisé pour gérer les variables d'environnement, ce qui permet de configurer l'application sans avoir à modifier le code source.
