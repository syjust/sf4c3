<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* game/home.html.twig */
class __TwigTemplate_8eb58a59e455f007a15e79feebe4b55869745e001c5439fd986b6516d8aee1d1 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'content_id' => [$this, 'block_content_id'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "game/home.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "game/home.html.twig"));

        // line 3
        $macros["utils"] = $this->macros["utils"] = $this->loadTemplate("_macro.html.twig", "game/home.html.twig", 3)->unwrap();
        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "game/home.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 5
    public function block_content_id($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "content_id"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "content_id"));

        echo "game";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 7
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "content"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "content"));

        // line 8
        echo "    ";
        echo twig_call_macro($macros["utils"], "macro_breadcrumb", [["home" => "game_home"]], 8, $context, $this->getSourceContext());
        echo "

    <h2>";
        // line 10
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("game.title"), "html", null, true);
        echo "</h2>

    <p class=\"attempts\">
        ";
        // line 13
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("game.attempts", ["%count%" => twig_get_attribute($this->env, $this->source, (isset($context["game"]) || array_key_exists("game", $context) ? $context["game"] : (function () { throw new RuntimeError('Variable "game" does not exist.', 13, $this->source); })()), "remainingAttempts", [], "any", false, false, false, 13)]), "html", null, true);
        echo "
    </p>

    <ul class=\"word-letters\">
        ";
        // line 17
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["game"]) || array_key_exists("game", $context) ? $context["game"] : (function () { throw new RuntimeError('Variable "game" does not exist.', 17, $this->source); })()), "wordLetters", [], "any", false, false, false, 17));
        foreach ($context['_seq'] as $context["_key"] => $context["letter"]) {
            // line 18
            echo "            <li class=\"";
            echo ((twig_get_attribute($this->env, $this->source, (isset($context["game"]) || array_key_exists("game", $context) ? $context["game"] : (function () { throw new RuntimeError('Variable "game" does not exist.', 18, $this->source); })()), "isLetterFound", [0 => $context["letter"]], "method", false, false, false, 18)) ? ("guessed") : ("not-guessed"));
            echo "\">";
            // line 19
            ((twig_get_attribute($this->env, $this->source, (isset($context["game"]) || array_key_exists("game", $context) ? $context["game"] : (function () { throw new RuntimeError('Variable "game" does not exist.', 19, $this->source); })()), "isLetterFound", [0 => $context["letter"]], "method", false, false, false, 19)) ? (print (twig_escape_filter($this->env, twig_upper_filter($this->env, $context["letter"]), "html", null, true))) : (print ("?")));
            // line 20
            echo "</li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['letter'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 22
        echo "    </ul>

    <p class=\"attempts\">
        <a href=\"";
        // line 25
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("game_reset");
        echo "\">";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("game.reset"), "html", null, true);
        echo "</a>
    </p>

    <br class=\"clearfix\" />

    <h2>";
        // line 30
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("game.try_letter"), "html", null, true);
        echo "</h2>

    <ul>
        ";
        // line 33
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(range("A", "Z"));
        foreach ($context['_seq'] as $context["_key"] => $context["letter"]) {
            // line 34
            echo "            <li class=\"letter btn\">
                <a href=\"";
            // line 35
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("game_play_letter", ["letter" => $context["letter"]]), "html", null, true);
            echo "\">
                    ";
            // line 36
            echo twig_escape_filter($this->env, twig_upper_filter($this->env, $context["letter"]), "html", null, true);
            echo "
                </a>
            </li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['letter'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 40
        echo "    </ul>

    <h2>";
        // line 42
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("game.try_word"), "html", null, true);
        echo "</h2>

    <form action=\"";
        // line 44
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("game_play_word");
        echo "\" method=\"post\" class=\"form-inline\">
        <div class=\"form-group\">
            <input name=\"word\" class=\"form-control mb-2\" placeholder=\"";
        // line 46
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("game.form.word"), "html", null, true);
        echo "\"/>
        </div>
        <button>";
        // line 48
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans("game.form.submit"), "html", null, true);
        echo "</button>
    </form>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "game/home.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  188 => 48,  183 => 46,  178 => 44,  173 => 42,  169 => 40,  159 => 36,  155 => 35,  152 => 34,  148 => 33,  142 => 30,  132 => 25,  127 => 22,  120 => 20,  118 => 19,  114 => 18,  110 => 17,  103 => 13,  97 => 10,  91 => 8,  81 => 7,  62 => 5,  51 => 1,  49 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% import '_macro.html.twig' as utils %}

{% block content_id 'game' %}

{% block content %}
    {{ utils.breadcrumb({'home': 'game_home'}) }}

    <h2>{{ 'game.title'|trans }}</h2>

    <p class=\"attempts\">
        {{ 'game.attempts'|trans({'%count%':game.remainingAttempts}) }}
    </p>

    <ul class=\"word-letters\">
        {% for letter in game.wordLetters %}
            <li class=\"{{ game.isLetterFound(letter) ? 'guessed' : 'not-guessed' }}\">
                {{- game.isLetterFound(letter) ? letter|upper : '?' -}}
            </li>
        {% endfor %}
    </ul>

    <p class=\"attempts\">
        <a href=\"{{ path('game_reset') }}\">{{ 'game.reset'|trans }}</a>
    </p>

    <br class=\"clearfix\" />

    <h2>{{ 'game.try_letter'|trans }}</h2>

    <ul>
        {% for letter in 'A'..'Z' %}
            <li class=\"letter btn\">
                <a href=\"{{ path('game_play_letter', {'letter' : letter}) }}\">
                    {{ letter|upper }}
                </a>
            </li>
        {% endfor %}
    </ul>

    <h2>{{ 'game.try_word'|trans }}</h2>

    <form action=\"{{ path('game_play_word') }}\" method=\"post\" class=\"form-inline\">
        <div class=\"form-group\">
            <input name=\"word\" class=\"form-control mb-2\" placeholder=\"{{ 'game.form.word'|trans }}\"/>
        </div>
        <button>{{ 'game.form.submit'|trans }}</button>
    </form>
{% endblock %}
", "game/home.html.twig", "/Users/sylvainjust/Sites/sf4c3/SF4C4_hangman_begin/hangman/templates/game/home.html.twig");
    }
}
