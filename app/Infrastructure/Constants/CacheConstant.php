<?php

namespace App\Infrastructure\Constants;

class CacheConstant
{
	const CACHE_KEY_CMA_ECOM_API_OAUTH = "niya_cma_ecom_api_outh";
	const CACHE_KEY_CMA_EMAIL_API_OAUTH = "niya_cma_email_api_outh";
  const CACHE_KEY_CMA_COCKPIT_API_OAUTH = "niya_cma_cockpit_api_outh";
	const CACHE_KEY_CMA_TRANSCO_API_OAUTH = "niya_cma_transco_api_outh";
  const CACHE_KEY_CMA_COCKPIT_UAT_API_OAUTH = "niya_cma_cockpit_uat_api_outh";
	const CACHE_KEY_CMA_TRANSCO_UAT_API_OAUTH = "niya_cma_transco_uat_api_outh";

  // DURATION
  const CACHE_DURATION_30_MINS_IN_SECONDS = 1800;
  const CACHE_DURATION_1_HOUR_IN_SECONDS = 3600;
  const CACHE_DURATION_24_HOURS_IN_SECONDS = 86400;

  // DATABASE
  const CACHE_KEY_DATABASE_ARAL = "niya_database_aral";
  const CACHE_KEY_DATABASE_MYSQL = "niya_database_rds";
  const CACHE_KEY_REDIS = "niya_redis";
  const CACHE_KEY_PREFIX_DEFAULT = "niya_";

  // TARGETS
  const CACHE_TARGET_REDIS = "redis";
  const CACHE_TARGET_APCU = "apcu";

  // CARRIERS
  const CARRIERS_KEY = 'carriers';

  // LARA . PARTNERS
  const LARA_PARTNERS_GROUP_DETAILS_KEY = 'lara.partners.groups.';
  const LARA_PARTNERS_DETAILS_KEY = 'lara.partners.details.';
  const LARA_EDI_PARTNERS_DETAILS_KEY = 'lara.edi.partners.details.';
  const LARA_EDI_PARTNERS_LIST_KEY = 'lara.edi.partners.list.';
  const LARA_PARTNERCODE_DETAILS_KEY = 'lara.partnercode.details.';

  // PROJECTS
  const PROJECTS_CHANNELS_KEY = 'projects.channels';
  const PROJECTS_CHANNEL_TYPES_KEY = 'projects.channel_types';
  const PROJECTS_GEOGRAPHICAL_SCOPES_KEY = 'projects.geographical_scopes';
  const PROJECTS_INTEGRATION_TYPES_KEY = 'projects.integration_types';
  const PROJECTS_PROJECT_LEADS_KEY = 'projects.project_leads';
  const PROJECTS_MESSAGE_TYPES_KEY = 'projects.message_types';
  const PROJECTS_MILESTONES_KEY = 'projects.milestones';
  const PROJECTS_PRIORITIES_KEY = 'projects.priorities';
  const PROJECTS_PRODUCTS_KEY = 'projects.products';
  const PROJECTS_PROJECT_TYPES_KEY = 'projects.project_types';
  const PROJECTS_STATUS_KEY = 'projects.status';
  const PROJECTS_PROJECT_TEAMS_KEY = 'projects.project_teams';
  const PROJECTS_WEATHER_KEY = 'projects.weathers';
  const PROJECTS_WORKLOAD_KEY = 'projects.workloads';
  const PROJECTS_TAG_KEY = 'projects.tags';

  // PORJECTS . PARTNERS
  const PROJECTS_PARTNERS_ALL_KEY = 'projects.partners.all';
  const PROJECTS_PARTNERS_ACTIVE_KEY = 'projects.partners.active';
  const PROJECTS_PARTNERS_CUSTOMERS_ACTIVE_KEY = 'projects.partners.customers.active';
  const PROJECTS_PARTNERS_PLATFORMS_ACTIVE_KEY = 'projects.partners.platforms.active';
  const PROJECTS_PARTNER_TYPES_KEY = 'projects.partners.partner_types';
  const PROJECTS_PARTNER_CATEGORIES_KEY = 'projects.partners.partner_categories';
  const PROJECTS_PARTNER_SEGMENTS_KEY = 'projects.partners.partner_segments';
  const PROJECTS_PARTNER_GEOGRAPHICAL_SCOPES_KEY = 'projects.partners.partner_geographical_scopes';

  const PROJECTS_USER_PREFERRED_VIEW_KEY = 'projects.preffered_view.user.';

  // PROJECT . PARTNERIDCARD
  const PROEJCT_PARTNERIDCARD_PRICING_EDI_USAGE = 'projects.partneridcard.pricing_edi_usage';

  // PROJECT ROADMAP
  const PROJECTS_ROADMAP_STATUS = 'projects.roadmap.status';

  // USER PERMISSION & ROLES
  const USER_PERMISSIONS_KEY = 'user.permissions.';
  const USER_ROLES_KEY = 'user.roles.';


  // B2b Onboarding
  const B2B_ONBOARDING_CHANNELS_KEY = 'b2bonboarding.channels';
  const B2B_ONBOARDING_CHANNEL_TYPES_KEY = 'b2bonboarding.channel_types';
  const B2B_ONBOARDING_COUNTRYS_KEY = 'b2bonboarding.countries';
  const B2B_ONBOARDING_PARTNER_LIST_KEY = 'b2bonboarding.partner_list';
  const B2B_ONBOARDING_ECOMMERECE_RO_KEY = 'b2bonboarding.ecommerce_ro_list';
  const B2B_ONBOARDING_REQUEST_TYPE_LIST_KEY = 'b2bonboarding.request_types_list';


  const B2B_ONBOARDING_GEOGRAPHICAL_SCOPES_KEY = 'b2bonboarding.geographical_scopes';
  const B2B_ONBOARDING_INTEGRATION_TYPES_KEY = 'b2bonboarding.integration_types';
  const B2B_ONBOARDING_PROJECT_LEADS_KEY = 'b2bonboarding.project_leads';
  const B2B_ONBOARDING_MESSAGE_TYPES_KEY = 'b2bonboarding.message_types';
  const B2B_ONBOARDING_MILESTONES_KEY = 'b2bonboarding.milestones';
  const B2B_ONBOARDING_PRIORITIES_KEY = 'b2bonboarding.priorities';
  const B2B_ONBOARDING_PRODUCTS_KEY = 'b2bonboarding.products';
  const B2B_ONBOARDING_PROJECT_TYPES_KEY = 'b2bonboarding.project_types';
  const B2B_ONBOARDING_STATUS_KEY = 'b2bonboarding.status';
  const B2B_ONBOARDING_PROJECT_TEAMS_KEY = 'b2bonboarding.project_teams';
  const B2B_ONBOARDING_WEATHER_KEY = 'b2bonboarding.weathers';
  const B2B_ONBOARDING_WORKLOAD_KEY = 'b2bonboarding.workloads';
  const B2B_ONBOARDING_PRODUCT_DETAIL_KEY = 'b2bonboarding.product_detail';

  const B2B_ONBOARDING_COCKPIT_PARTNER_DETAILS = 'cockpit.partners.details.';
  const B2B_ONBOARDING_COCKPIT_SIMILAR_PARTNERS = 'cockpit.similarpartners.';
  const B2B_ONBOARDING_PRODUCT_MSGSETUP_KEY = 'b2bonboarding.product_msgsetup';
}
